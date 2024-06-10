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

    it(description: 'throws an error if redirect url is invalid', closure: function () {

        MockClient::global([
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-redirect-uri-invalid'),
        ]);

        $dto = new AuthorizationRequestDTO(
            provider: Provider::GOOGLE,
            redirect_uri: 'http://localhost:9999999999999999/callback',
        );

        expect(
            value: fn () => (new UserManagement())->getAuthorizationURL($dto)
        )->toThrow(
            exception: WorkosRequestException::class,
            exceptionMessage: trans(key: 'workos::workos.exceptions.redirect_uri_invalid')
        );
    });

    it(description: 'throws an error if client id is invalid', closure: function () {

        MockClient::global([
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-client-id-invalid'),
        ]);

        $dto = new AuthorizationRequestDTO(
            provider: Provider::AUTHKIT,
            redirect_uri: 'http://localhost:5173/callback',
        );

        expect(
            value: fn () => (new UserManagement())->getAuthorizationURL($dto)
        )->toThrow(
            exception: WorkosRequestException::class,
            exceptionMessage: trans(key: 'workos::workos.exceptions.client_id_invalid')
        );
    });

});
