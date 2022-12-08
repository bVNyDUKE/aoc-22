<?php

$fp = fopen('src/input.txt', "r");

$cals = [];
$pos = 0;

while ($row = fgets($fp)) {
    if ($row === "\n") {
        $pos++;
    }

    $cals[$pos] = isset($cals[$pos]) ? $cals[$pos] +  intval($row) : intval($row);
}

rsort($cals);
echo array_sum(array_slice($cals, 0, 3));
