<?php

$lines = explode(PHP_EOL, trim(file_get_contents('src/9/input.txt', "r")));
$lines = array_map(fn ($a) => explode(" ", trim($a)), $lines);

function getTailPos(array $tailPos, array $headPos)
{
    [$tX, $tY] = $tailPos;
    [$hX, $hY] = $headPos;

    $newX = $tX;
    $newY = $tY;

    if (abs($tY - $hY) + abs($tX - $hX) >= 3) {
        $newX = $hX > $tX ? ++$tX : --$tX;
        $newY = $hY > $tY ? ++$tY : --$tY;
        return [$newX, $newY];
    }

    if (abs($hX - $tX) >= 2) {
        $newX = $hX > $tX ? ++$tX : --$tX;
    }

    if (abs($hY - $tY) >= 2) {
        $newY = $hY > $tY ? ++$tY : --$tY;
    }

    return [$newX, $newY];
}

const KNOTS = 9;

$k = [];

foreach (range(0, KNOTS) as $_) {
    $k[] = [
        [0, 0]
    ];
}

foreach ($lines as [$dir, $count]) {
    $count = intval($count);
    for ($c = 0; $c < $count; $c++) {
        [$hX, $hY] = $k[0][array_key_last($k[0])];
        $newHead = [];
        switch ($dir) {
            case 'R':
                $newHead = [$hX + 1, $hY];
                break;
            case 'L':
                $newHead = [$hX - 1, $hY];
                break;
            case 'U':
                $newHead = [$hX, $hY + 1];
                break;
            case 'D':
                $newHead = [$hX, $hY - 1];
                break;
        }

        $k[0][] = $newHead;

        for ($i = 1; $i < KNOTS + 1; $i++) {
            $newT = getTailPos($k[$i][array_key_last($k[$i])], $k[$i - 1][array_key_last($k[$i - 1])]);
            $k[$i][] = $newT;
        }
    }
}


$a = array_unique($k[KNOTS], SORT_REGULAR);
print_r(count($a));
