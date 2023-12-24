<?php

require __DIR__ . '/./vendor/autoload.php';

use Amp\Pipeline\Pipeline;
use function Amp\delay;

$pipeline = Pipeline::fromIterable(function (): \Generator {
    for ($i = 0; $i < 100; ++$i) {
        try {
            if ($i !== 50) {
                yield [
                    'success' => true,
                    'value' => $i
                ];
            }
            else {
                throw new Exception("Exception value is 50");
            }
        } catch (\Throwable $th) {
            yield [
                'success' => false,
                'message' => $th->getMessage()
            ];
        }
    }
});

$pipeline = $pipeline
    ->concurrent(10) // Process up to 10 items concurrently
    ->unordered() // Results may arrive out of order
    ->delay(1); // Fake suspense time for api call

foreach ($pipeline as $item) {
    if ($item['success']) {
        echo $item['value'], "\n";
    }
    else {
        echo '(' . $item['message'] . ')', "\n";
    }
}