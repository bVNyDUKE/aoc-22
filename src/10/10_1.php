<?php

$lines = explode(PHP_EOL, trim(file_get_contents('src/10/input.txt', "r")));
$lines = array_map(fn ($a) => explode(" ", trim($a)), $lines);

$cycle = 1;
$reg = 1;

$target_cycles = [20, 60, 100, 140, 180, 220];
$vals = [];

foreach ($lines as $l) {
    $cmd = $l[0];

    if ($cmd === 'addx') {
        for ($i = 0; $i < 2; $i++) {
            ++$cycle;
            if ($i == 1) {
                $reg += intval($l[1]);
            }
            if (in_array($cycle, $target_cycles)) {
                $vals[] = $cycle * $reg;
            }
        }
        continue;
    } else {
        ++$cycle;
        if (in_array($cycle, $target_cycles)) {
            $vals[] = $cycle * $reg;
        }
    }
}

print_r($vals);
print_r(array_sum($vals));
