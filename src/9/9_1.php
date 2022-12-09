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

$h = [0, 0];
$t = [
    [0, 0]
];


foreach ($lines as [$dir, $count]) {
    $count = intval($count);
    print_r($dir);
    for ($c = 0; $c < $count; $c++) {
        print_r($c);
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
        $h = $newHead;
        $newT = getTailPos($t[array_key_last($t)], $h);
        print_r($h);
        print_r($newT);

        $t[] = $newT;
    }
}


$a = array_unique($t, SORT_REGULAR);
print_r(count($a));
