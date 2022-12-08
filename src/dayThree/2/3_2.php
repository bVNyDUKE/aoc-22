<?php

function toNum(string $char): int
{
    if ($char === strtoupper($char)) {
        return ord($char) - 38;
    }
    return ord($char) - 96;
}

$groups = [];
$counter = 0;
$pos = 0;

$fp = fopen('./src/dayThree/2/input.txt', 'r');
while ($row = trim(fgets($fp))) {
    if (!isset($groups[$counter])) {
        $groups[$counter] = [];
    }

    for ($i = 0; $i < strlen($row); $i++) {
        $groups[$counter][$pos][] = $row[$i];
    }

    $pos++;
    if ($pos % 3 === 0) {
        $counter++;
    }
}

$keys = [];
foreach ($groups as $group) {
    $val = array_intersect(...$group);
    $keys[] = toNum(array_pop($val));
}
echo array_sum($keys);
