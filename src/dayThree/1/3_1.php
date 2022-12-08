<?php

function toNum(string $char): int
{
    if ($char === strtoupper($char)) {
        return ord($char) - 38;
    }
    return ord($char) - 96;
}

$fp = fopen('./src/dayThree/1/input.txt', 'r');
$inBoth = [];

while ($row = trim(fgets($fp))) {
    $middle = floor(strlen($row) / 2);
    $first = [];
    $second = [];

    for ($i = 0; $i < $middle; $i++) {
        $first[] = toNum($row[$i]);
    }

    for ($i = $middle; $i < strlen($row); $i++) {
        $second[] = toNum($row[(int) $i]);
    }

    $double = array_intersect(array_unique($first), array_unique($second));
    foreach ($double as $d) {
        $inBoth[] = $d;
    }

    printf("\n");
}
print_r($inBoth);
print_r(array_sum($inBoth));
