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

$t = [
    [
        [0, 0],
    ],
    [
        [0, 0]
    ],
    [
        [0, 0]
    ],
    [
        [0, 0]
    ],
    [
        [0, 0]
    ],
    [
        [0, 0]
    ],
    [
        [0, 0]
    ],
    [
        [0, 0]
    ],
    [
        [0, 0]
    ],
    [
        [0, 0]
    ],
];

function makeMove(array $h, array $t, string $dir): array
{
    [$hX, $hY] = $h;
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
    $newT = getTailPos($t[array_key_last($t)], $h);
    return [$newHead, $newT];
}

foreach ($lines as [$dir, $count]) {
    $count = intval($count);
    for ($c = 0; $c < $count; $c++) {
        [$hX, $hY] = $t[0][array_key_last($t[0])];
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

        $t[0][] = $newHead;

        for ($i = 1; $i < 10; $i++) {
            $newT = getTailPos($t[$i][array_key_last($t[$i])], $t[$i - 1][array_key_last($t[$i - 1])]);
            $t[$i][] = $newT;
        }
    }
}


$a = array_unique($t[9], SORT_REGULAR);
print_r(count($a));
