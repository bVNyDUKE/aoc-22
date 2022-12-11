<?php

class Monkey
{
    public int $timesInspected = 0;
    public int $mod = 0;

    public function __construct(
        public array $items,
        public string $operation,
        public int $testNumber,
        public int $targetIfTrue,
        public int $targetIfFalse
    ) {
    }

    public function round(): array
    {
        $thrownItems = [];
        foreach ($this->items as $item) {
            ++$this->timesInspected;
            $i = $this->calculateWorry($item);
            $target = $this->throwTarget($i);
            $thrownItems[] = [
                'target' => $target,
                'item' => $i,
            ];
        }
        $this->items = [];
        return $thrownItems;
    }

    public function test(string $item): bool
    {
        return bcmod($item, $this->testNumber) == 0;
    }

    public function calculateWorry(string $item): string
    {
        $op = explode(':', trim($this->operation))[1];
        $op = substr($op, 7);
        $op = explode(' ', $op);
        $first = $op[0] === 'old' ? $item : intval($op[0]);
        $second = $op[2] === 'old' ? $item : intval($op[2]);

        if ($op[1] === '+') {
            return ($first + $second) % $this->mod;
        }

        return ($first * $second) % $this->mod;
    }

    public function throwTarget(string $item): int
    {
        if ($this->test($item)) {
            return $this->targetIfTrue;
        }

        return $this->targetIfFalse;
    }

    public function addItem(string $item): void
    {
        $this->items[] = $item;
    }
}

$lines = explode(PHP_EOL . PHP_EOL, trim(file_get_contents('src/day11/input.txt', "r")));
$lines = array_map(fn ($a) => explode(PHP_EOL, trim($a)), $lines);

print_r($lines);

$monkeys = [];
foreach ($lines as $line) {
    $startingItems = explode(':', $line[1]);
    $startingItems = explode(', ', trim($startingItems[1]));

    $op = trim($line[2]);

    $testNumber = explode(' ', trim($line[3]));
    $testNumber = array_pop($testNumber);

    $targetIfTrue = explode(' ', trim($line[4]));
    $targetIfTrue = array_pop($targetIfTrue);

    $targetifFalse = explode(' ', trim($line[5]));
    $targetifFalse = array_pop($targetifFalse);

    $m = new Monkey(
        $startingItems,
        $op,
        $testNumber,
        $targetIfTrue,
        $targetifFalse,
    );

    $monkeys[] = $m;
}

$mod = 1;
foreach ($monkeys as $m) {
    $mod *= $m->testNumber;
}

foreach ($monkeys as $m) {
    $m->mod = $mod;
}


for ($round = 0; $round < 10_000; $round++) {
    for ($m = 0; $m < count($monkeys); $m++) {
        $res = $monkeys[$m]->round();
        foreach ($res as $r) {
            $monkeys[$r['target']]->addItem($r['item']);
        }
    }
}

$results = [];
array_walk($monkeys, function (Monkey $m, int $index) use (&$results) {
    $results[$index] = $m->timesInspected;
});

rsort($results);
print_r($results[0] * $results[1]);
