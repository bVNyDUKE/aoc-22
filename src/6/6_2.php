<?php

$s = trim(file_get_contents('src/6/input.txt', "r"));
$chars = [];
for ($i = 0; $i < strlen($s); $i++) {
    if ($i > 14) {
        if ($chars === array_unique($chars)) {
            print_r(array_unique($chars));
            printf("\n");
            print_r(strpos($s, implode('', $chars)) + 14);
            break;
        }
    }

    if (count($chars) === 14) {
        array_shift($chars);
    }

    array_push($chars, $s[$i]);
}
