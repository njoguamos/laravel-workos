<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\Connectors\WorkosConnector;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\GetAuthURLRequest;
use Saloon\Enums\Method;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it(description: 'has the correct method', closure: function () {
    $request = new GetAuthURLRequest(
        client_id: 'client_12432546358',
        provider: Provider::GOOGLE,
        redirect_uri: "https://example.com/callback"
    );

    expect(value: $request->getMethod())->toBe(expected: Method::GET);
});

it(description: 'has the correct endpoint', closure: function () {
    $request = new GetAuthURLRequest(
        client_id: 'client_12432546358',
        provider: Provider::MICROSOFT,
        redirect_uri: "https://example.com/callback"
    );

    expect(value: $request->resolveEndpoint())->toBe(expected: '/user_management/authorize');
});

it(description: 'has the correct query params', closure: function () {
    $request = new GetAuthURLRequest(
        client_id: 'client_666666',
        provider: Provider::APPLE,
        redirect_uri: "https://example.com/callback"
    );

    expect(value: $request->query()->all())->toBe(expected: [
        "client_id"     => 'client_666666',
        "provider"      => Provider::APPLE->value,
        "redirect_uri"  => "https://example.com/callback",
        "response_type" => "code",
  ]);
});

it(description: 'throws an exception when redirect url contain a know error` ', closure: function (string $code, string $url, string $message) {

    MockClient::global(mockData: [
        GetAuthURLRequest::class => MockResponse::make(
            body: "Found. Redirecting to $url",
            status: 302,
            headers: ['Location' => $url]
        ),
    ]);

    $connector = app(abstract: WorkosConnector::class);

    $request = new GetAuthURLRequest(
        client_id: 'client_1242354',
        provider: Provider::APPLE,
        redirect_uri: "https://example.com/callback"
    );

    expect(
        value: fn () => $connector->send(request: $request)
    )->toThrow(
        exception: RequestException::class,
        exceptionMessage: $message
    );

})->with([
    'Code challenge is missing' => [
        'code_challenge_missing',
        'https://error.workos.com/sso/code_challenge_missing',
        fn () => trans(key: 'workos::workos.exceptions.code_challenge_missing'),
    ],
    'Invalid redirect url' => [
        'redirect-uri-invalid',
        'https://error.workos.com/sso/redirect-uri-invalid',
        fn () => trans(key: 'workos::workos.exceptions.redirect_uri_invalid'),
    ],
    'Invalid client id' => [
        'client-id-invalid',
        'https://error.workos.com/sso/client-id-invalid',
        fn () => trans(key: 'workos::workos.exceptions.client_id_invalid'),
    ],
    'Invalid organisation id' => [
        'organization_invalid',
        'http://localhost:5173/callback?error_description=No%20Connection%20associated%20with%20Organization%20%27org_1234567890%27&error=organization_invalid&error_uri=https%3A%2F%2Fworkos.com%2Fdocs%2Freference%2Fsso%2Fget-authorization-url%2Ferror-codes',
        fn () => trans(key: 'workos::workos.exceptions.organization_invalid'),
    ],
    'Invalid connection id' => [
        'connection_invalid',
        'http://localhost:5173/callback?error_description=No%20Connection%20found%20with%20ID%20%27conn_123456%27&error=connection_invalid&error_uri=https%3A%2F%2Fworkos.com%2Fdocs%2Freference%2Fsso%2Fget-authorization-url%2Ferror-codes',
        fn () => trans(key: 'workos::workos.exceptions.connection_invalid'),
    ],
    'Access denied' => [
        'access_denied',
        'https://error.workos.com/sso/access_denied',
        fn () => trans(key: 'workos::workos.exceptions.access_denied'),
    ],
    'connection strategy is invalid' => [
        'connection_strategy_invalid',
        'https://error.workos.com/sso/connection_strategy_invalid',
        fn () => trans(key: 'workos::workos.exceptions.connection_strategy_invalid'),
    ],
    'connection used was unlinked' => [
        'connection_unlinked',
        'https://error.workos.com/sso/connection_unlinked',
        fn () => trans(key: 'workos::workos.exceptions.connection_unlinked'),
    ],
    'invalid connection selector is provided' => [
        'invalid_connection_selector',
        'https://error.workos.com/sso/invalid_connection_selector',
        fn () => trans(key: 'workos::workos.exceptions.invalid_connection_selector'),
    ],
    'oauth failed' => [
        'oauth_failed',
        'https://error.workos.com/sso/oauth_failed',
        fn () => trans(key: 'workos::workos.exceptions.oauth_failed'),
    ],
    'server error occurred' => [
        'server_error',
        'https://error.workos.com/sso/server_error',
        fn () => trans(key: 'workos::workos.exceptions.server_error'),
    ],
]);
