<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Exceptions\WorkosRequestException;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\GetAuthorizationURLRequest;
use NjoguAmos\LaravelWorkos\UserManagement;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

describe(description: 'get an authorization url', tests: function () {

    it(description: 'throws an error if redirect url is invalid', closure: function () {

        new MockClient([
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-redirect-uri-invalid'),
        ]);

        config()->set(key: 'workos.client_id', value: 'client_01HZ82ZG4W0NNAKZ9MEHF3RSCF');

        expect(
            value: fn () => (new UserManagement())
                ->getAuthorizationURL(
                    provider: Provider::AUTHKIT,
                    redirectUri: 'http://localhost:99999999/callback',
                )
        )->toThrow(
            exception: WorkosRequestException::class,
            exceptionMessage: trans(key: 'workos::workos.exceptions.redirect_uri_invalid')
        );
    });

    it(description: 'throws an error if client id is invalid', closure: function () {

        new MockClient([
            GetAuthorizationURLRequest::class => MockResponse::fixture(name: 'GetAuthorizationURL-client-id-invalid'),
        ]);

        expect(
            value: fn () => (new UserManagement())
                ->getAuthorizationURL(
                    provider: Provider::AUTHKIT,
                    redirectUri: 'http://localhost:5173/callback',
                )
        )->toThrow(
            exception: WorkosRequestException::class,
            exceptionMessage: trans(key: 'workos::workos.exceptions.client_id_invalid')
        );
    });

});
