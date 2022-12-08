<?php

$lines = explode(PHP_EOL, trim(file_get_contents('src/8/input.txt', "r")));
$lines = array_map(fn ($a) => str_split(trim($a)), $lines);

function calcScenicScore(array $view, int $limit)
{
    $s = 0;
    foreach ($view as $tree) {
        $s += 1;
        if ($tree >= $limit) {
            break;
        }
    }
    return $s;
}


$score = 0;
foreach ($lines as $i => $line) {
    if ($i === 0 || $i === array_key_last($lines)) {
        continue;
    }

    foreach ($line as $col => $tree) {
        if ($col === 0  || $col === array_key_last($line)) {
            continue;
        }

        $vertical = array_map(fn ($row) =>  $row[$col], $lines);

        $top = calcScenicScore(array_reverse(array_slice($vertical, 0, $i)), $tree);
        $left = calcScenicScore(array_reverse(array_slice($line, 0, $col)), $tree);
        $bottom = calcScenicScore(array_slice($vertical, $i + 1), $tree);
        $right = calcScenicScore(array_slice($line, $col + 1), $tree);

        $total = ($top * $left * $bottom * $right);

        if ($total > $score) {
            $score = $total;
        }
    }
}

print_r($score);
