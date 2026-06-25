<?php

declare(strict_types=1);

return [
    'position' => 'top-right',
    'theme' => 'system',
    'fill' => null,
    'roundness' => 16,
    'duration' => 4000,
    'autopilot' => null,
    'styles' => [
        'title' => null,
        'description' => null,
        'badge' => null,
        'button' => null,
    ],
    'toaster' => [
        'offset' => null,
    ],
    'events' => [
        'toast' => 'sileo',
        'promise' => 'sileo.promise',
        'resolve_prefix' => 'sileo.resolve.',
        'reject_prefix' => 'sileo.reject.',
    ],
];
