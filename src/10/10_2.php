<?php

$lines = explode(PHP_EOL, trim(file_get_contents('src/10/input.txt', "r")));
$lines = array_map(fn ($a) => explode(" ", trim($a)), $lines);

$cycle = 1;
$reg = 1;

const HEIGHT = 6;
const WIDTH = 40;

$screen = [];
for ($h = 0; $h < HEIGHT; $h++) {
    for ($w = 0; $w < WIDTH; $w++) {
        $screen[$h][$w] = '.';
    }
}

function cycleChange(int $cycle, int $reg, array &$screen): void
{
    $spritePosition = [$reg - 1, $reg, $reg + 1];
    $drawingPixel = $cycle - 1;

    $row = floor($cycle / WIDTH);

    if ($row > 0) {
        $drawingPixel = $drawingPixel - $row * WIDTH;
    }

    if (in_array($drawingPixel, $spritePosition)) {
        $screen[$row][$drawingPixel] = '#';
    }
}


foreach ($lines as $l) {
    $cmd = $l[0];

    if ($cmd === 'addx') {
        for ($i = 0; $i < 2; $i++) {
            cycleChange($cycle, $reg, $screen);
            ++$cycle;
            if ($i == 1) {
                $reg += intval($l[1]);
            }
        }
        continue;
    } else {
        cycleChange($cycle, $reg, $screen);
        ++$cycle;
    }
}

print_r(array_map(fn ($l) => implode('', $l), $screen));
