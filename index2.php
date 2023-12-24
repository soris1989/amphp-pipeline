<?php

require __DIR__ . '/./vendor/autoload.php';

use Amp\Pipeline\Pipeline;
use function Amp\delay;

$urls = [
    'https://secure.php.net',
    'https://amphp.org',
    'https://github.com',
    'https://www.upress.co.il',
    'https://google.com',
    'https://hidabroot.org',
    'https://getbootstrap.com/',
    'https://stackoverflow.com/',
    'https://diromat.com/',
    'https://reactphp.org',
    'https://processwire.com',
    'https://dev.to',
    'https://dreamhost.com',
    'https://www.brevo.com',
    'https://docs.aws.amazon.com',
    'https://laracasts.com',
    'https://superuser.com',
    'https://www.educba.com',
];

$pipeline = Pipeline::fromIterable(function () use ($urls): \Generator  {
    foreach ($urls as $url) {
        yield file_get_contents($url);
    }
});

$pipeline = $pipeline
    ->concurrent(3); // Process up to 10 items concurrently

foreach ($pipeline as $value) {
    echo $value, "\n";
}