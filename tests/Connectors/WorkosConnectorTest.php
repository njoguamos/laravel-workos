<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\Connectors\WorkosConnector;

it(description: 'can bind config values', closure: function () {
    $connector = app(abstract: WorkosConnector::class);

    expect(value: $connector->apiKey)->toBe(expected: config(key: 'workos.api_key'))
        ->and(value: $connector->clientId)->toBe(expected: config(key: 'workos.client_id'))
        ->and(value: $connector->apiBaseurl)->toBe(expected: config(key: 'workos.api_base_url'));
});


it(description: 'set the default headers', closure: function () {
    $connector = app(abstract: WorkosConnector::class);

    $expectedHeaders = [
        'Content-Type' => 'application/json',
        'Accept'       => 'application/json',
    ];

    expect(value: $connector->headers()->all())->toBe(expected: $expectedHeaders);
});
