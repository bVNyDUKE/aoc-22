<?php

$signals = explode(PHP_EOL, trim(file_get_contents('src/6/input.txt', "r")));

foreach ($signals as $s) {
    $chars = [];
    for ($i = 0; $i < strlen($s); $i++) {
        if ($i > 3) {
            if ($chars === array_unique($chars)) {
                print_r(array_unique($chars));
                printf("\n");
                print_r(strpos($s, implode('', $chars)) + 4);
                break;
            }
        }

        if (count($chars) === 4) {
            array_shift($chars);
        }

        array_push($chars, $s[$i]);
    }
}
