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
        if (!array_key_exists('total', $root)) {
            $root['total'] = 0;
        }

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
}

const TOTAL = 70_000_000;
const NEEDED = 30_000_000;

$unused = TOTAL - $root['/']['total'];
$target = NEEDED - $unused;

function getResult(array $arr, int $target): array
{
    $res = [];
    if ($arr['total'] >= $target) {
        $res[] = $arr['total'];
    }

    foreach ($arr as $a) {
        if (is_array($a)) {
            $res[] = getResult($a, $target);
        }
    }

    return $res;
}

function flatten(array $arr)
{
    $return = [];
    array_walk_recursive($arr, function ($a) use (&$return) {
        $return[] = $a;
    });
    return $return;
}

$dirs = flatten(getResult($root['/'], $target));
print_r(min(array_filter($dirs, fn ($d) => $d >= $target)));
