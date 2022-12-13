<?php

$lines = explode(PHP_EOL . PHP_EOL, trim(file_get_contents('src/13/example.txt', "r")));
$lines = array_map(fn ($a) => explode(PHP_EOL, trim($a)), $lines);

$r = [];

function cmp(array|int &$f, array|int &$s): bool
{
    if (is_int($f) && is_array($s)) {
        $f = [$f];
    } elseif (is_int($s) && is_array($f)) {
        $s = [$s];
    } elseif (is_int($f) && is_int($s)) {
        return $f <= $s;
    }

    $order = true;
    while (count($f) && count($s)) {
        $ff = array_shift($f);
        $ss = array_shift($s);

        $order = cmp($ff, $ss);

        if (!$order) {
            return $order;
        }
    }

    if (!count($f) && count($s)) {
        $order = true;
        return $order;
    }

    if (count($f) && !count($s)) {
        $order = false;
        return $order;
    }

    return $order;
}

foreach ($lines as $i => $pack) {
    $f = $s = [];
    eval('$f = ' . $pack[0] . ';');
    eval('$s = ' . $pack[1] . ';');

    if (count($f) > count($s)) {
        continue;
    }

    if (!isset($f[0]) && isset($s[0])) {
        $r[] = $i + 1;
        continue;
    }

    $ord = true;
    for ($k = 0; $k < count($f); $k++) {
        $ord = cmp($f[$k], $s[$k]);
    }

    if ($ord) {
        $r[] = $i + 1;
    }
}

print_r(array_unique($r));
