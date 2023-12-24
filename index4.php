<?php

require __DIR__ . '/./vendor/autoload.php';

use Amp\Pipeline\Pipeline;
use function Amp\delay;

$pipeline = Pipeline::fromIterable(function (): \Generator {
    for ($i = 0; $i < 100; ++$i) {
        yield $i;
    }
});

$pipeline = $pipeline
    ->concurrent(3) // Process up to 3 items concurrently
    ->unordered() // Results may arrive out of order
    ->delay(1) // Delay for 1 second to simulate I/O
    ->forEach(function (int $value): void {
        echo $value, "\n";
    });