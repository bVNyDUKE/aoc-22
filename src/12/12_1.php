<?php

$lines = explode(PHP_EOL, trim(file_get_contents('src/12/input.txt', "r")));
$lines = array_map(fn ($a) => str_split(trim($a)), $lines);

$graph = [];
$rows = count($lines);
$cols = count($lines[0]);

foreach ($lines as $rowIndex => $row) {
    foreach ($row as $colIndex => $cell) {
        if ($cell === "S") {
            $graph[$rowIndex][$colIndex] = 1;
        } elseif ($cell === "E") {
            $graph[$rowIndex][$colIndex] = 26;
        } else {
            $graph[$rowIndex][$colIndex] = ord($lines[$rowIndex][$colIndex]) - ord('a') + 1;
        }
    }
}

$queue = [];
foreach ($lines as $r => $row) {
    foreach ($lines as $c => $col) {
        if ($lines[$r][$c] == 'S') {
            array_push($queue, [[$r, $c], 0]);
        }
    }
}

$seen = [];
while ([[$r, $c], $d] = array_shift($queue)) {
    if (in_array([$r, $c], $seen)) {
        continue;
    }

    array_push($seen, [$r, $c]);
    if ($lines[$r][$c] == 'E') {
        print_r($d);
        return $d;
    }
    foreach ([[-1, 0], [0, 1], [1, 0], [0, -1]] as $dir) {
        $rr = $r + $dir[0];
        $cc = $c + $dir[1];
        if ((0 <= $rr && $rr < $rows) && (0 <= $cc && $cc < $cols) && ($graph[$rr][$cc] <= 1 + $graph[$r][$c])) {
            array_push($queue, [[$rr, $cc], $d + 1]);
        }
    }
}
