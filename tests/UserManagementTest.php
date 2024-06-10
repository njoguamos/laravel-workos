<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\DTOs\AuthorizationRequestDTO;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Exceptions\WorkosRequestException;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\GetAuthorizationURLRequest;
use NjoguAmos\LaravelWorkos\UserManagement;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

describe(description: 'get an authorization url', tests: function () {

    it(description: 'can get authorization url` ', closure: function (Provider $provider, string $redirect_uri, string $prefix) {

        MockClient::global(mockData: [
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-success-'.$provider->name),
        ]);

        $dto = new AuthorizationRequestDTO(
            provider: $provider,
            redirect_uri: $redirect_uri,
        );

        $response = (new UserManagement())->getAuthorizationURL(dto: $dto);

        expect(value: str_contains(haystack: $response, needle: $prefix))->toBeTrue();

    })->with([
        'Google Provider'    => [ Provider::GOOGLE, 'http://localhost:5173/callback', 'https://accounts.google.com/o/oauth2/v2/auth'],
        'Microsoft Provider' => [ Provider::MICROSOFT, 'http://localhost:5173/callback', 'https://login.microsoftonline.com/consumers/oauth2/v2.0/authorize'],
        'Authkit Provider'   => [ Provider::AUTHKIT, 'http://localhost:5173/callback', 'https://test.authkit.app']
    ]);

    it(description: 'throws an exception when code challenge is missing from the request` ', closure: function () {

        MockClient::global(mockData: [
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-code_challenge_missing'),
        ]);


        $dto = new AuthorizationRequestDTO(
            provider: Provider::GOOGLE,
            redirect_uri: 'http://localhost:5173/callback',
            code_challenge_method: 'S256',
        );

        expect(
            value: fn () => (new UserManagement())->getAuthorizationURL(dto: $dto)
        )->toThrow(
            exception: WorkosRequestException::class,
            exceptionMessage: trans(key: 'workos::workos.exceptions.code_challenge_missing')
        );

    });

    it(description: 'throws an exception if redirect url is invalid', closure: function () {

        MockClient::global(mockData: [
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-redirect-uri-invalid'),
        ]);

        $dto = new AuthorizationRequestDTO(
            provider: Provider::GOOGLE,
            redirect_uri: 'http://localhost:9999999999999999/callback',
        );

        expect(
            value: fn () => (new UserManagement())->getAuthorizationURL(dto: $dto)
        )->toThrow(
            exception: WorkosRequestException::class,
            exceptionMessage: trans(key: 'workos::workos.exceptions.redirect_uri_invalid')
        );
    });

    it(description: 'throws an exception if client id is invalid', closure: function () {

        MockClient::global(mockData: [
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-client-id-invalid'),
        ]);

        $dto = new AuthorizationRequestDTO(
            provider: Provider::AUTHKIT,
            redirect_uri: 'http://localhost:5173/callback',
        );

        expect(
            value: fn () => (new UserManagement())->getAuthorizationURL(dto: $dto)
        )->toThrow(
            exception: WorkosRequestException::class,
            exceptionMessage: trans(key: 'workos::workos.exceptions.client_id_invalid')
        );
    });

    it(description: 'throws an exception if the organization provided is invalid', closure: function () {

        MockClient::global(mockData: [
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-organization_invalid'),
        ]);

        $dto = new AuthorizationRequestDTO(
            provider: Provider::AUTHKIT,
            redirect_uri: 'http://localhost:5173/callback',
            organization_id: 'org_1234567890',
        );

        expect(
            value: fn () => (new UserManagement())->getAuthorizationURL(dto: $dto)
        )->toThrow(
            exception: WorkosRequestException::class,
            exceptionMessage: trans(key: 'workos::workos.exceptions.organization_invalid')
        );
    });

    it(description: 'throws an exception if access denied')->todo();
    it(description: 'throws an exception if a connection could not be uniquely identified using the provided connection selector')->todo();
    it(description: 'throws an exception if the connection invalid')->todo();
    it(description: 'throws an exception if the connection strategy is invalid')->todo();
    it(description: 'throws an exception if the connection used was unlinked')->todo();
    it(description: 'throws an exception if the invalid connection selector is provided')->todo();
    it(description: 'throws an exception if oauth failed')->todo();
    it(description: 'throws an exception if server error occurs')->todo();

});
