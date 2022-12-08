<?php

$count = 0;

$fp = fopen('src/4/input.txt', "r");
while ($row = trim(fgets($fp))) {
    [$f, $s] = explode(',', $row);
    [$ff, $fs] = explode('-', $f);
    [$sf, $ss] = explode('-', $s);

    $first = [];
    $second = [];
    for ($i = $ff; $i <= $fs; $i++) {
        $first[] = $i;
    }

    for ($i = $sf; $i <= $ss; $i++) {
        $second[] = $i;
    }

    //1
    /* if (array_intersect($first, $second) === $first || array_intersect($second, $first) === $second) { */
    /*     $count++; */
    /* } */

    //2
    if (array_intersect($first, $second) || array_intersect($second, $first)) {
        $count++;
    }
}

echo $count;
