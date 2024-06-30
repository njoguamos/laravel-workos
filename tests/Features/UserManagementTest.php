<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use NjoguAmos\LaravelWorkOS\Enums\AuthMethod;
use NjoguAmos\LaravelWorkOS\Enums\Provider;
use NjoguAmos\LaravelWorkOS\Enums\WorkOSObject;
use NjoguAmos\LaravelWorkOS\Requests\AuthWithCodeRequest;
use NjoguAmos\LaravelWorkOS\Requests\CreateUserRequest;
use NjoguAmos\LaravelWorkOS\Requests\GetAuthURLRequest;
use NjoguAmos\LaravelWorkOS\Requests\GetUserRequest;
use NjoguAmos\LaravelWorkOS\Tests\Factories\AuthUserFactory;
use NjoguAmos\LaravelWorkOS\Tests\Factories\UserFactory;
use NjoguAmos\LaravelWorkOS\UserManagement;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

describe(description: 'User', tests: function () {

    /**
     * @link [Get a user](https://workos.com/docs/reference/user-management/user/get)
     */
    it(description: 'can get user', closure: function () {
        $mockResponse = UserFactory::create();

        MockClient::global(mockData: [
            GetUserRequest::class => MockResponse::make(body: $mockResponse),
        ]);

        $response = (new UserManagement())->getUser(id: $mockResponse['id']);

        expect(value: $response)
            ->object->toBeInstanceOf(class: WorkOSObject::class)
            ->id->toBe(expected: $mockResponse['id'])
            ->email->toBe(expected: $mockResponse['email'])
            ->email_verified->toBe(expected: $mockResponse['email_verified'])
            ->created_at->toBeInstanceOf(class: CarbonImmutable::class)
            ->updated_at->toBeInstanceOf(class: CarbonImmutable::class)
            ->first_name->toBe(expected: $mockResponse['first_name'])
            ->last_name->toBe(expected: $mockResponse['last_name'])
            ->profile_picture_url->toBe(expected: $mockResponse['profile_picture_url']);
    });

    /**
     * @link [Create a user](https://workos.com/docs/reference/user-management/user/create)
     */
    it(description: 'can create a user', closure: function () {
        $user = (new UserFactory())->create();
        $password = Str::password();

        MockClient::global(mockData: [
            CreateUserRequest::class => MockResponse::make(body: $user),
        ]);

        $response = (new UserManagement())->createUser(
            email: $user['email'],
            password: $password,
            first_name: $user['first_name'],
            last_name: $user['last_name'],
            email_verified: $user['email_verified'],
        );

        expect(value: $response)
            ->object->toBeInstanceOf(class: WorkOSObject::class)
            ->id->toBe(expected: $user['id'])
            ->email->toBe(expected: $user['email'])
            ->email_verified->toBe(expected: $user['email_verified'])
            ->created_at->toBeInstanceOf(class: CarbonImmutable::class)
            ->updated_at->toBeInstanceOf(class: CarbonImmutable::class)
            ->first_name->toBe(expected: $user['first_name'])
            ->last_name->toBe(expected: $user['last_name'])
            ->profile_picture_url->toBe(expected: $user['profile_picture_url']);
    });

});

describe(description: 'Authorization url', tests: function () {

    /**
     * @link [Get an authorization URL](https://workos.com/docs/reference/user-management/authentication/get-authorization-url)
     */
    it(description: 'can get authorization url ', closure: function () {
        $provider = Arr::random(Provider::cases());
        $url = fake()->url();

        MockClient::global(mockData: [
            GetAuthURLRequest::class => MockResponse::make(
                body: "Found. Redirecting to $url",
                status: 302,
                headers: ['Location' => $url]
            ),
        ]);

        $response = (new UserManagement())
            ->getAuthorizationURL(
                provider: $provider->value,
                redirect_uri: 'http://localhost:5173/callback',
            );

        expect(value: $response)
            ->url->toBe(expected: $url)
            ->provider->toBe(expected: $provider);
    });
});

describe(description: 'Authenticate with code', tests: function () {

    /**
     * @link [Authenticate with code](https://workos.com/docs/reference/user-management/authentication/code)
     */
    it(description: 'can authenticate user with a valid code', closure: function () {
        $mockResponse = (new AuthUserFactory())->create();

        MockClient::global(mockData: [
            AuthWithCodeRequest::class => MockResponse::make(body: $mockResponse),
        ]);

        $response = (new UserManagement())
            ->authenticateWithCode(
                code: (string) Str::ulid(),
                ip_address: fake()->ipv4(),
                user_agent: fake()->userAgent()
            );

        expect(value: $response)
            ->user->object->toBeInstanceOf(WorkOSObject::class)
            ->user->id->toBe($mockResponse['user']['id'])
            ->user->email->toBe($mockResponse['user']['email'])
            ->user->email_verified->toBe($mockResponse['user']['email_verified'])
            ->user->created_at->toBeInstanceOf(class: CarbonImmutable::class)
            ->user->updated_at->toBeInstanceOf(class: CarbonImmutable::class)
            ->user->first_name->toBe($mockResponse['user']['first_name'])
            ->user->last_name->toBe($mockResponse['user']['last_name'])
            ->user->profile_picture_url->toBe($mockResponse['user']['profile_picture_url'])
            ->access_token->toBe($mockResponse['access_token'])
            ->refresh_token->toBe($mockResponse['refresh_token'])
            ->authentication_method->toBeInstanceOf(AuthMethod::class)
            ->organization_id->toBe($mockResponse['organization_id'])
            ->impersonator->toBeNull();
    });
});
