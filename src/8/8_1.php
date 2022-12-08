<?php

$lines = explode(PHP_EOL, trim(file_get_contents('src/8/input.txt', "r")));
$lines = array_map(fn ($a) => str_split(trim($a)), $lines);

$vis = 0;
foreach ($lines as $i => $line) {
    if ($i === 0 || $i === array_key_last($lines)) {
        $vis += count($lines);
        continue;
    }

    foreach ($line as $col => $tree) {
        if ($col === 0  || $col === array_key_last($line)) {
            $vis += 1;
            continue;
        }

        $vertical = array_map(fn ($row) =>  $row[$col], $lines);

        if (
            $tree > max(array_slice($line, 0, $col)) ||
            $tree > max(array_slice($line, $col + 1)) ||
            $tree > max(array_slice($vertical, 0, $i)) ||
            $tree > max(array_slice($vertical, $i + 1))
        ) {
            $vis += 1;
        }
    }
}

print_r($vis);
