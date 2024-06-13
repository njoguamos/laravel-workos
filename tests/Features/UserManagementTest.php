<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\DTOs\CodeAuthDTO;
use NjoguAmos\LaravelWorkos\DTOs\AuthUrlDTO;
use NjoguAmos\LaravelWorkos\Enums\AuthMethod;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\AuthWithCodeRequest;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\GetAuthURLRequest;
use NjoguAmos\LaravelWorkos\UserManagement;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it(description: 'can get authorization url ', closure: function (Provider $provider, string $redirect_uri, string $url) {

    MockClient::global(mockData: [
        GetAuthURLRequest::class => MockResponse::make(
            body: "Found. Redirecting to $url",
            status: 302,
            headers: ['Location' => $url]
        ),
    ]);

    $dto = new AuthUrlDTO(
        provider: $provider,
        redirect_uri: $redirect_uri,
    );

    $response = (new UserManagement())->getAuthorizationURL(dto: $dto);

    expect(value: str_contains(haystack: $response, needle: $url))->toBeTrue();

})->with([
    'Google Provider'    => [ Provider::GOOGLE, 'http://localhost:5173/callback', "https:\/\/accounts.google.com\/o\/oauth2\/v2\/auth?access_type=offline&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&state=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcGkiOiJ1c2VyX21hbmFnZW1lbnQiLCJyZWRpcmVjdF91cmkiOiJodHRwOi8vbG9jYWxob3N0OjUxNzMvY2FsbGJhY2siLCJpYXQiOjE3MTgwMzY4NTMsImV4cCI6MTcxODAzNzc1M30.XVLCkLerRvwuVzC_Qrugbi3mzN36g8ROJQKiGGVOL8w&response_type=code&client_id=107873717349-glhtihlrvlblbs4u94teon3o5fcqb79f.apps.googleusercontent.com&redirect_uri=https%3A%2F%2Fauth.workos.com%2Fsso%2Foauth%2Fgoogle%2FLIDju2jt3JCqKGExIexjgOSQ1%2Fcallback"],
    'Microsoft Provider' => [ Provider::MICROSOFT, 'http://localhost:5173/callback', "https:\/\/login.microsoftonline.com\/consumers\/oauth2\/v2.0\/authorize?client_id=d9daa0d2-dec8-4a26-9382-8f28db04d50d&scope=email%20profile%20openid%20offline_access&redirect_uri=https%3A%2F%2Fauth.workos.com%2Fsso%2Foauth%2Fmicrosoft%2Fcallback&client-request-id=3a88daa7-88f9-45e9-abb3-6bd4846f8180&response_mode=query&response_type=code&x-client-SKU=msal.js.node&x-client-VER=1.14.6&x-client-OS=linux&x-client-CPU=x64&client_info=1&prompt=select_account&state=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcGkiOiJ1c2VyX21hbmFnZW1lbnQiLCJyZWRpcmVjdF91cmkiOiJodHRwOi8vbG9jYWxob3N0OjUxNzMvY2FsbGJhY2siLCJlbnZpcm9ubWVudF9pZCI6ImVudmlyb25tZW50XzAxSFo4MlpGU1M5RzRHSFZaTVc5R0ZEQ1RGIiwiaWF0IjoxNzE4MDQzNTcwLCJleHAiOjE3MTgwNDQ0NzB9.kDPVA7_ubv6KTYQ3pHrIjASbXZi9rRKwcmLwkDRvQeM",],
    'Authkit Provider'   => [ Provider::AUTHKIT, 'http://localhost:5173/callback', "https:\/\/test.authkit.app?client_id=client_123456789&redirect_uri=http%3A%2F%2Flocalhost%3A5173%2Fcallback&response_type=code&authorization_session_id=01J01JJ7NF9NWA745XR63PWGNP",]
]);



it(description: 'can authenticate user with a valid code', closure: function () {

    $responseData = [
        "user" => [
            "object"              => "user",
            "id"                  => "user_01E4ZCR3C56J083X43JQXF3JK5",
            "email"               => "marcelina.davis@example.com",
            "email_verified"      => true,
            "created_at"          => "2021-06-25T19:07:33.155Z",
            "updated_at"          => "2021-06-25T19:07:33.155Z",
            "first_name"          => "Marcelina",
            "last_name"           => "Davis",
            "profile_picture_url" => "https://workoscdn.com/images/v1/123abc",
        ],
        "access_token"          => "eyJhb.nNzb19vaWRjX2tleV9.lc5Uk4yWVk5In0",
        "refresh_token"         => "yAjhKk123NLIjdrBdGZPf8pLIDvK",
        "authentication_method" => "GoogleOAuth",
        "organization_id"       => "org_01H945H0YD4F97JN9MATX7BYAG",
        "impersonator"          => null
    ];

    MockClient::global(mockData: [
        AuthWithCodeRequest::class => MockResponse::make(body: $responseData),
    ]);

    $dto = new CodeAuthDTO(
        code: '01HZDJKXHRS9DVDN74B4W22M3M',
        ip_address: '168.0.2.45',
        user_agent: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
    );

    $response = (new UserManagement())->authenticateWithCode(dto: $dto);

    expect($response->array())->toBe([...$responseData, "authentication_method" => AuthMethod::GOOGLE]);
});
