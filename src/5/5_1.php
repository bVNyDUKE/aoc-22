<?php

[$data, $commands] = explode(PHP_EOL . PHP_EOL, file_get_contents('src/5/input.txt', "r"));
$data = explode(PHP_EOL, $data);
$rows = array_pop($data);


$initial = [];
for ($i = 0; $i < strlen($rows); $i++) {
    $key = $rows[$i];
    if ($rows[$i] === ' ') {
        continue;
    }

    foreach ($data as $d) {
        if ($d[$i] === ' ') {
            continue;
        }

        if (!isset($initial[$key])) {
            $initial[$key] = [];
        }

        $initial[$key][] = $d[$i];
    }
    $initial[$key] = array_reverse($initial[$key]);
}


foreach (explode(PHP_EOL, $commands) as $cmd) {
    [, $count,, $from,, $to] = explode(' ', $cmd);
    for ($i = $count; $i > 0; $i--) {
        array_push($initial[$to], array_pop($initial[$from]));
    }
}

$msg = '';
foreach ($initial as $crate) {
    $msg .= array_pop($crate);
}
print_r($msg);
