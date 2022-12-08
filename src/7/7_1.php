<?php

$cmds = explode(PHP_EOL, trim(file_get_contents('src/7/input.txt', "r")));

$root = [];
$history = [];
$result = [];

function updateHistory(array $line, array &$h): void
{
    if ($line[1] === 'ls') {
        return;
    }

    if ($line[1] === 'cd') {
        if ($line[2] === '/') {
            $h = ['/'];
            return;
        }

        if ($line[2] === '..') {
            array_pop($h);
            return;
        }

        array_push($h, $line[2]);
    }
}

function updateFileArray(array &$root, array $history): void
{
    $key = array_shift($history);

    if ($key === null) {
        return;
    }

    if (!array_key_exists($key, $root)) {
        $root[$key] = [];
    }

    updateFileArray($root[$key], $history);
}

function handleLine(array $line, array &$root, array $history): void
{
    $key = array_shift($history);

    if ($key !== null) {
        handleLine($line, $root[$key], $history);
    } else {
        if (is_numeric($line[0])) {
            $root[] = $line[0];
        }
    }

    if (is_numeric($line[0])) {
        $root['total'] += $line[0];
    }
}


foreach ($cmds as $cmd) {
    $line = explode(' ', trim($cmd));

    if ($line[0] === "$") {
        updateHistory($line, $history);
        updateFileArray($root, $history);
    } else {
        handleLine($line, $root, $history);
    }

    print_r($root);
}

function getResult(array $arr): int
{
    $res = 0;
    if ($arr['total'] <= 100_000) {
        $res += $arr['total'];
    }

    foreach ($arr as $a) {
        if (is_array($a)) {
            $res += getResult($a);
        }
    }

    return $res;
}

print_r(getResult($root['/']));
