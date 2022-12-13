<?php

$lines = explode(PHP_EOL . PHP_EOL, trim(file_get_contents('src/13/input.txt', "r")));
$lines = array_map(fn ($a) => explode(PHP_EOL, trim($a)), $lines);

function cmp(array|int $f, array|int $s): int
{
    if (is_int($f) && is_int($s)) {
        if ($f < $s) {
            return -1;
        } elseif ($f == $s) {
            return 0;
        } else {
            return 1;
        }
    } elseif (is_array($f) && is_array($s)) {
        $i = 0;
        while ($i < count($f) && $i < count($s)) {
            $c = cmp($f[$i], $s[$i]);
            if ($c == -1) {
                return -1;
            }
            if ($c == 1) {
                return 1;
            }
            ++$i;
        }
        if ($i == count($f) && $i < count($s)) {
            return -1;
        } elseif ($i == count($s) && $i < count($f)) {
            return 1;
        } else {
            return 0;
        }
    } elseif (is_int($f) && is_array($s)) {
        return cmp([$f], $s);
    } else {
        return cmp($f, [$s]);
    }
}

$res = 0;
$packs = [];
foreach ($lines as $i => $pack) {
    $f = $s = [];
    eval('$f = ' . $pack[0] . ';');
    eval('$s = ' . $pack[1] . ';');

    array_push($packs, $f);
    array_push($packs, $s);

    if (cmp($f, $s) == -1) {
        $res += 1 + $i;
    }
}

array_push($packs, [[2]]);
array_push($packs, [[6]]);

usort($packs, "cmp");

$div1 = $div2 = 0;

foreach ($packs as $key => $val) {
    if ($val === [[2]]) {
        $div1 = $key + 1;
    }
    if ($val === [[6]]) {
        $div2 = $key + 1;
    }
}

print_r($div1 * $div2);
