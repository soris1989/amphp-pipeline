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
    ->concurrent(10) // Process up to 3 items concurrently
    ->unordered() // Results may arrive out of order
    ->tap(fn () => delay(1));

foreach ($pipeline as $value) {
    echo $value, "\n";
}