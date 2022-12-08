<?php


$points = [
    'X' => 1,
    'Y' => 2,
    'Z' => 3,
    'A' => 1,
    'B' => 2,
    'C' => 3,
    'win' => 6,
    'draw' => 3,
    'loss' => 0,
];

function play(string $first, string $second, array &$points): int
{
    $p1 = $points[$first];
    $p2 = $points[$second];

    if ($p1 === $p2) {
        print("draw\n");
        return $points['draw'] + $p2;
    }

    if ($p2 - $p1 === 1 || $p2 - $p1 === -2) {
        print("win\n");
        return $points['win'] + $p2;
    }

    print("loss\n");
    return $points['loss'] + $p2;
}


$fp = fopen('src/dayTwo/input.txt', "r");
$score = 0;
while ($row = fgets($fp)) {
    print($row);
    [$first, $second] = explode(' ', trim($row));
    $score += play($first, $second, $points);
}

print($score);
