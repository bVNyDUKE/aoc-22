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

function play(string $first, string $result, array &$points): int
{
    $p1 = $points[$first];

    if ($result === 'Y') {
        return 3 + $p1;
    }

    if ($result === 'X') {
        return $p1 === 1 ? 3 : $points[$first] - 1;
    }

    return $p1 === 3 ? 6 + 1 : 6 + $points[$first] + 1;
}


$fp = fopen('src/dayTwo/input.txt', "r");
/* $fp = fopen('src/dayTwo/example.txt', "r"); */
$score = 0;
while ($row = fgets($fp)) {
    print($row);
    [$first, $result] = explode(' ', trim($row));
    $score += play($first, $result, $points);
}

print($score);
