<?php

/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use NjoguAmos\LaravelWorkOS\Connectors\WorkOSConnector;
use NjoguAmos\LaravelWorkOS\Enums\GrantType;
use NjoguAmos\LaravelWorkOS\Exceptions\ApiKeyIsMissing;
use NjoguAmos\LaravelWorkOS\Exceptions\BadRequestException;
use NjoguAmos\LaravelWorkOS\Exceptions\ClientIdIsMissing;
use NjoguAmos\LaravelWorkOS\Exceptions\ForbiddenException;
use NjoguAmos\LaravelWorkOS\Exceptions\GatewayTimeoutException;
use NjoguAmos\LaravelWorkOS\Exceptions\InternalServerErrorException;
use NjoguAmos\LaravelWorkOS\Exceptions\NotFoundException;
use NjoguAmos\LaravelWorkOS\Exceptions\RateLimitReachedException;
use NjoguAmos\LaravelWorkOS\Exceptions\RequestTimeOutException;
use NjoguAmos\LaravelWorkOS\Exceptions\ServiceUnavailableException;
use NjoguAmos\LaravelWorkOS\Exceptions\UnauthorizedException;
use NjoguAmos\LaravelWorkOS\Exceptions\UnprocessableEntityException;
use NjoguAmos\LaravelWorkOS\Exceptions\WorkOSRequestException;
use NjoguAmos\LaravelWorkOS\Requests\AuthWithCodeRequest;
use NjoguAmos\LaravelWorkOS\Requests\GetUserRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it(description: 'can bind config values', closure: function () {
    $connector = app(abstract: WorkOSConnector::class);

    expect(value: $connector->getApiKey())->toBe(expected: config(key: 'workos.api_key'))
        ->and(value: $connector->getClientId())->toBe(expected: config(key: 'workos.client_id'))
        ->and(value: $connector->getApiBaseurl())->toBe(expected: config(key: 'workos.api_base_url'));
});

it(description: 'throws an exception if the api key is missing', closure: function () {
    config()->set(key: 'workos.api_key', value: '');

    $message = trans(key: 'workos::workos.exceptions.api_key_is_missing');

    expect(value: fn () => app(abstract: WorkOSConnector::class))->toThrow(exception: ApiKeyIsMissing::class, exceptionMessage: $message);
});

it(description: 'throws an exception if the client id is missing', closure: function () {
    config()->set(key: 'workos.client_id', value: '');

    $message = trans(key: 'workos::workos.exceptions.client_id_is_missing');

    expect(value: fn () => app(abstract: WorkOSConnector::class))->toThrow(exception: ClientIdIsMissing::class, exceptionMessage: $message);
});

it(description: 'can get credentials', closure: function () {
    $connector = app(abstract: WorkOSConnector::class);

    expect(value: $connector->getCredentials())->toBe(expected: [
        'client_id'     => config(key: 'workos.client_id'),
        'client_secret' => config(key: 'workos.api_key'),
    ]);
});

it(description: 'has the correct default Guzzle config', closure: function () {
    $connector = app(abstract: WorkOSConnector::class);

    expect(value: $connector->config()->all())->toBe(expected: [
        "allow_redirects" => false
    ]);
});

it(description: 'can get the correct exception message', closure: function (int $code, string $message, string $exception) {
    MockClient::global(mockData: [
        AuthWithCodeRequest::class => MockResponse::make(status: $code),
    ]);

    $request = new AuthWithCodeRequest(
        code: 'code',
        grant_type: GrantType::CODE
    );

    $connector = app(abstract: WorkOSConnector::class);

    expect(
        value: fn () => $connector->send(request: $request)
    )->toThrow(
        exception: WorkOSRequestException::class,
        exceptionMessage: $message
    )->toThrow(
        exception: $exception,
        exceptionMessage: $message
    );
})->with([
    400 => [400, fn () => trans(key: 'workos::workos.errors.400'),BadRequestException::class],
    401 => [401, fn () => trans(key: 'workos::workos.errors.401'),UnauthorizedException::class],
    403 => [403, fn () => trans(key: 'workos::workos.errors.403'), ForbiddenException::class],
    404 => [404, fn () => trans(key: 'workos::workos.errors.404'), NotFoundException::class],
    408 => [408, fn () => trans(key: 'workos::workos.errors.408'), RequestTimeOutException::class],
    422 => [422, fn () => trans(key: 'workos::workos.errors.422'),UnprocessableEntityException::class],
    429 => [429, fn () => trans(key: 'workos::workos.errors.429'), RateLimitReachedException::class],
    500 => [500, fn () => trans(key: 'workos::workos.errors.500'), InternalServerErrorException::class],
    503 => [503, fn () => trans(key: 'workos::workos.errors.503'), ServiceUnavailableException::class],
    504 => [504, fn () => trans(key: 'workos::workos.errors.504'), GatewayTimeoutException::class],
]);


it(description: 'should extend BaseWorkosConnector', closure: function () {
    $connector = new WorkOSConnector(
        apiKey: 'key',
        clientId: 'client_id',
        apiBaseurl: 'baseurl'
    );

    expect(value: $connector)->toBeInstanceOf(class: WorkOSConnector::class);
});

it(description: 'has the correct authorization header', closure: function () {
    MockClient::global(mockData: [ GetUserRequest::class => MockResponse::make() ]);

    $connector = new WorkOSConnector(
        apiKey: 'key',
        clientId: 'client_id',
        apiBaseurl: 'baseurl'
    );

    $response = $connector->send(request: new GetUserRequest(id: 'test'));

    $authHeader = $response->getPendingRequest()->headers()->get(key: 'Authorization');

    expect(value: $authHeader)->toBe(expected: 'Bearer key');
});
