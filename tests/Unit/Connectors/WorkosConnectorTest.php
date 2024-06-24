<?php

/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use NjoguAmos\LaravelWorkos\Connectors\WorkosConnector;
use NjoguAmos\LaravelWorkos\Exceptions\ApiKeyIsMissing;
use NjoguAmos\LaravelWorkos\Exceptions\ClientIdIsMissing;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\AuthWithCodeRequest;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\GetUserRequest;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it(description: 'can bind config values', closure: function () {
    $connector = app(abstract: WorkosConnector::class);

    expect(value: $connector->getApiKey())->toBe(expected: config(key: 'workos.api_key'))
        ->and(value: $connector->getClientId())->toBe(expected: config(key: 'workos.client_id'))
        ->and(value: $connector->getApiBaseurl())->toBe(expected: config(key: 'workos.api_base_url'));
});

it(description: 'throws an exception if the api key is missing', closure: function () {
    config()->set(key: 'workos.api_key', value: '');

    $message = trans(key: 'workos::workos.exceptions.api_key_is_missing');

    expect(value: fn () => app(abstract: WorkosConnector::class))->toThrow(exception: ApiKeyIsMissing::class, exceptionMessage: $message);
});

it(description: 'throws an exception if the client id is missing', closure: function () {
    config()->set(key: 'workos.client_id', value: '');

    $message = trans(key: 'workos::workos.exceptions.client_id_is_missing');

    expect(value: fn () => app(abstract: WorkosConnector::class))->toThrow(exception: ClientIdIsMissing::class, exceptionMessage: $message);
});

it(description: 'can get credentials', closure: function () {
    $connector = app(abstract: WorkosConnector::class);

    expect(value: $connector->getCredentials())->toBe(expected: [
        'client_id'     => config(key: 'workos.client_id'),
        'client_secret' => config(key: 'workos.api_key'),
    ]);
});

it(description: 'has the correct default Guzzle config', closure: function () {
    $connector = app(abstract: WorkosConnector::class);

    expect(value: $connector->config()->all())->toBe(expected: [
        "allow_redirects" => false
    ]);
});

it(description: 'can get the correct exception message', closure: function (int $code, string $message) {
    MockClient::global(mockData: [
        AuthWithCodeRequest::class => MockResponse::make(status: $code),
    ]);

    $request = new AuthWithCodeRequest(code: 'code');

    $connector = app(abstract: WorkosConnector::class);

    expect(
        value: fn () => $connector->send(request: $request)
    )->toThrow(
        exception: RequestException::class,
        exceptionMessage: $message
    );
})->with([
    400 => [400, fn () => trans(key: 'workos::workos.errors.400')],
    401 => [401, fn () => trans(key: 'workos::workos.errors.401')],
    403 => [403, fn () => trans(key: 'workos::workos.errors.403')],
    404 => [404, fn () => trans(key: 'workos::workos.errors.404')],
    422 => [422, fn () => trans(key: 'workos::workos.errors.422')],
]);


it(description: 'should extend BaseWorkosConnector', closure: function () {
    $connector = new WorkosConnector(
        apiKey: 'key',
        clientId: 'client_id',
        apiBaseurl: 'baseurl'
    );

    expect(value: $connector)->toBeInstanceOf(class: WorkosConnector::class);
});

it(description: 'has the correct authorization header', closure: function () {
    MockClient::global(mockData: [ GetUserRequest::class => MockResponse::make() ]);

    $connector = new WorkosConnector(
        apiKey: 'key',
        clientId: 'client_id',
        apiBaseurl: 'baseurl'
    );

    $response = $connector->send(request: new GetUserRequest(id: 'test'));

    $authHeader = $response->getPendingRequest()->headers()->get(key: 'Authorization');

    expect(value: $authHeader)->toBe(expected: 'Bearer key');
});
