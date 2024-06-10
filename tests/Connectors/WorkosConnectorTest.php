<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\Connectors\WorkosConnector;
use NjoguAmos\LaravelWorkos\Exceptions\ApiKeyIsMissing;
use NjoguAmos\LaravelWorkos\Exceptions\ClientIdIsMissing;

it(description: 'can bind config values', closure: function () {
    $connector = app(abstract: WorkosConnector::class);

    expect(value: $connector->apiKey)->toBe(expected: config(key: 'workos.api_key'))
        ->and(value: $connector->clientId)->toBe(expected: config(key: 'workos.client_id'))
        ->and(value: $connector->apiBaseurl)->toBe(expected: config(key: 'workos.api_base_url'));
});


it(description: 'set the default headers', closure: function () {
    $connector = app(abstract: WorkosConnector::class);

    $expectedHeaders = [
        'Content-Type' => 'application/json'
    ];

    expect(value: $connector->headers()->all())->toBe(expected: $expectedHeaders);
});

it(description: 'throws an exception if the api key is missing', closure: function () {
    config()->set(key: 'workos.api_key', value: '');

    $message = trans(key: 'workos::workos.exceptions.api_key_is_missing');

    expect(fn () => app(abstract: WorkosConnector::class))->toThrow(exception: ApiKeyIsMissing::class, exceptionMessage: $message);
});

it(description: 'throws an exception if the client id is missing', closure: function () {
    config()->set(key: 'workos.client_id', value: '');

    $message = trans(key: 'workos::workos.exceptions.client_id_is_missing');

    expect(fn () => app(abstract: WorkosConnector::class))->toThrow(exception: ClientIdIsMissing::class, exceptionMessage: $message);
});
