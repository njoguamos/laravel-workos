> [!CAUTION]
> This package is still under development and not ready for production use.

# A fluent Laravel package for interacting with WorkOS API.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/njoguamos/laravel-workos.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-workos)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-workos/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/njoguamos/laravel-workos/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-workos/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/njoguamos/laravel-workos/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/njoguamos/laravel-workos.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-workos)

@TODO: Add package description here.

## Why use This package?

- ✅ The package has been optimised for Laravel 10+
- ✅ Offer developer friendly error handling e.g. `Get an authorization URL Errors`
- ✅ Offers language translations 
- ✅ Users Data Object Transfer for efficient data handling, in-and-out of the WorkOS API.
- ✅ Automatically prevent hitting rate limits and handle retries.
- ✅ TODO: Add more reasons here

## Installation

You can install the package via composer:

```bash
composer require njoguamos/laravel-workos
```

Update your `.env` file with the following
    
```dotenv
WORKOS_API_KEY=
WORKOS_CLIENT_ID=
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="workos-config"
```

You can publish the translations  file with:

```bash
php artisan vendor:publish --tag="workos-translations"
```

## Usage

### 0.Requests, Response and Errors

### 0.1 Making Request to WorkOs API

Under the hood, this package uses [Saloon](https://github.com/saloonphp/saloon) to make requests to the WorkOS API.

When making requests, your must instantiate the corresponding Data Transfer Objects (DTOs). These DTOs are powered by [Spatie Laravel Data](https://github.com/spatie/laravel-data). DTOs makes it easier to pass data to-and-fro the WorkOS API.

Here is an example on how to make a request and handle errors.

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use NjoguAmos\LaravelWorkos\DTOs\CodeAuthDTO;
use NjoguAmos\LaravelWorkos\DTOs\AuthUserDTO;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\UserManagement;

class AuthorizationUrlController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string'],
        ]);

        try {
            $dto = new CodeAuthDTO(
                provider: $validated['code'],
                ip_address: $request->ip(),
                user_agent: $request->userAgent()
            );

            /** @var AuthUserDTO $user */
            $authUser = (new UserManagement())->authenticateWithCode($dto);
        } catch (\Saloon\Exceptions\Request\FatalRequestException $e) {
            // Request did not reach the WorkOS API. Handle it.
        } catch (\Saloon\Exceptions\Request\RequestException $e) {
            // Request reached the WorkOS API but 4xx or 5xx error occurred. Handle it.
        }

        // You have a user. Do something with it.
        return response()->json($authUser->json());
    }
}
```

### 0.2 Response Handling

The default response format is a DTO object. This object instance differs depending on the request made. For example, for the about request the response is an instance of `CodeAuthDTO`.

```php
use NjoguAmos\LaravelWorkos\DTOs\AuthUserDTO;
use NjoguAmos\LaravelWorkos\UserManagement;

/** @var AuthUserDTO $user */
$authUser = (new UserManagement())->authenticateWithCode($dto);

dd($authUser);
```
The die-dump outputs the following.

```php
NjoguAmos\LaravelWorkos\DTOs\AuthUserDTO {#1457
  +user: NjoguAmos\LaravelWorkos\DTOs\UserDTO {#1532
    +object: "user"
    +id: "user_01E4ZCR3C56J083X43JQXF3JK5"
    +email: "marcelina.davis@example.com"
    +email_verified: true
    +created_at: "2021-06-25T19:07:33.155Z"
    +updated_at: "2021-06-25T19:07:33.155Z"
    +first_name: "Marcelina"
    +last_name: "Davis"
    +profile_picture_url: "https://workoscdn.com/images/v1/123abc"
  }
  +access_token: "eyJhb.nNzb19vaWRjX2tleV9.lc5Uk4yWVk5In0"
  +refresh_token: "yAjhKk123NLIjdrBdGZPf8pLIDvK"
  +authentication_method: "GoogleOAuth"
  +organization_id: "org_01H945H0YD4F97JN9MATX7BYAG"
  +impersonator: null
  #response: Saloon\Http\Response {#1528}
}
```

And when die-dump the json `dd($authUser->json())`

```json
{
    "user": {
        "object": "user",
        "id": "user_01E4ZCR3C56J083X43JQXF3JK5",
        "email": "marcelina.davis@example.com",
        "email_verified": true,
        "created_at": "2021-06-25T19:07:33.155Z",
        "updated_at": "2021-06-25T19:07:33.155Z",
        "first_name": "Marcelina",
        "last_name": "Davis",
        "profile_picture_url": "https://workoscdn.com/images/v1/123abc"
    },
    "access_token": "eyJhb.nNzb19vaWRjX2tleV9.lc5Uk4yWVk5In0",
    "refresh_token": "yAjhKk123NLIjdrBdGZPf8pLIDvK",
    "authentication_method": "GoogleOAuth",
    "organization_id": "org_01H945H0YD4F97JN9MATX7BYAG",
    "impersonator": null
}
```

### 0.3 Response Errors

If an error occurs, the package will throw either of the of exceptions.

1. `Saloon\Exceptions\Request\FatalRequestException`.

This exception is thrown when the package encountered a problem before the WorkOS API was able to respond. For example: An issue with connecting to the API or an SSL error.

You can access the pending PendingRequest that caused the exception by calling the `getPendingRequest` method on the exception which will return an instance of `Saloon\Http\PendingRequest`. This comes with handy methods to help you debug the request.

```php
try {
    // ...
} 
} catch (\Saloon\Exceptions\Request\FatalRequestException $e) {
    $e->getMessage(); // Gets the Exception message
    $e->getCode(); // Gets the Exception code
    $pendingRequest = $e->getPendingRequest(); // Get the PendingRequest that caused the exception.
    $body = $pendingRequest->body(); // Retrieve the body on the instance
    $request = $pendingRequest->getRequest(); // Get the request
    $headers = $request->headers(); //Access the headers
    
    // Use the IDE auto-completion to see more methods.
}
````

2. `Saloon\Exceptions\Request\RequestException` 

This exception is thrown when the WorkOS API responds with a 4xx or 5xx error. You can access the response by calling the `getResponse` method on the exception which will return an instance of `Saloon\Http\Response`. The response class comes with handy methods to help you debug the response. A list of all these methods is available in [Saloon Documentation](https://docs.saloon.dev/the-basics/responses#useful-methods)

```php
try {
    // ...
} 
} catch (\Saloon\Exceptions\Request\RequestException $e) {
    $e->status(); // Get the HTTP status code.
    $e->body(); // Returns the raw response body as a string
    $e->json(); // Retrieves a JSON response body and json_decodes it into an array.
    $->getPsrRequest(); // The PSR-7 request that was built up by Saloon
    $->getPsrResponse(); // The PSR-7 response that was built up by the HTTP client/sender.
    
    // Use the IDE auto-completion to see more methods.
}
````

3. `Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException`

```php
try {
   // ...
} catch (RateLimitReachedException $exception) {
    $seconds = $exception->getLimit()->getRemainingSeconds();
    
    // Return our users back to our application with a custom response that could be 
    // shown on the front end.
}
```

### 1. Events

<details open>

<summary>List events</summary>

- [ ] TODO

</details>

### 2. Organization

<details open>

<summary>Get an Organization</summary>

- [ ] TODO

</details>

<details open>

<summary>List Organizations</summary>

- [ ] TODO

</details>

<details open>

<summary>Create an Organization</summary>

- [ ] TODO

</details>

<details open>

<summary>Update an Organization</summary>

- [ ] TODO

</details>

<details open>

<summary>Delete an Organization</summary>

- [ ] TODO

</details>

### 3. User Management

#### 3.1 User Management
<details open>

<summary>Get a user</summary>

- [ ] TODO

</details>

<details open>

<summary>List users</summary>

- [ ] TODO

</details>

<details open>

<summary>Create a user</summary>

- [ ] TODO

</details>

<details open>

<summary>Update a user</summary>

- [ ] TODO

</details>

<details open>

<summary>Delete a user</summary>

- [ ] TODO

</details>

#### 3.2 Identities

<details open>

<summary>Get user identities</summary>

- [ ] TODO

</details>

#### 3.3 Authentication


<details>

<summary>Get an authorization URL</summary>

To get the authorization URL, call the `getAuthorizationURL` method of `UserManagement` class. The method accepts an instance of `AuthorizationRequestDTO` as an argument.

```php
use NjoguAmos\LaravelWorkos\DTOs\AuthUrlDTO;
use NjoguAmos\LaravelWorkos\UserManagement;
use NjoguAmos\LaravelWorkos\Enums\Provider;

$dto = new AuthUrlDTO(
    provider: Provider::GOOGLE,
    redirect_uri: 'http://localhost:3000/callback',
);

$url = (new UserManagement())->getAuthorizationURL($dto);
```

 You should redirect your users to `response URL` to complete the authentication. 

```text
https://accounts.google.com/o/oauth2/v2/auth?access_type=offline&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&state=eyJhbGciOiJIUzIGHJKDSFSFGGF7.eyJhcGkiOiJ1c2VyX21hbmFnZW1lbnQiLCJyZWRpcmVjdF91cmkiOiJodHRwOi8vbG9jYUYGASFIUFSGUIF76sDFGsjgdytUIYXQiOjE3MTgwMzY4NTMsImV4cCI6MTcxODAzNzc1M30.XVLCkLerRvwuVzC_Qrugbi3mzN36g8ROJQKiGGVOL8w&response_type=code&client_id=107873717349-glhtihlrvlblbs4u94teon3o5fcqb79f.apps.googleusercontent.com&redirect_uri=https%3A%2F%2Fauth.workos.com%2Fsso%2Foauth%2Fgoogle%2FLIDju2jt3JCqKGExIexjgOSQ1%2Fcallback
```

> [!NOTE]
> The `AuthorizationRequestDTO` class accepts the following parameters: `provider`, `redirect_uri`, `response_type`, `code_challenge`, `code_challenge_method`, `connection_id`, `organization_id`, `state`, `login_hint`, `domain_hint` and `screen_hint`. Learn more form the [official documentation](https://workos.com/docs/reference/user-management/authentication/get-authorization-url).

> [!IMPORTANT]
> This package will automatically throw exception [authorization URL errors](https://workos.com/docs/reference/user-management/authentication/get-authorization-url/error-codes). The error messages are descriptive so that you know what went wrong.


</details>

<details open>

<summary>Authenticate with code</summary>

- [ ] TODO

</details>

<details open>

<summary>Authenticate a user with password</summary>

- [ ] TODO

</details>

<details open>

<summary>Authenticate with Magic Auth</summary>

- [ ] TODO

</details>

<details open>

<summary>Authenticate with refresh token</summary>

- [ ] TODO

</details>

<details open>

<summary>Authenticate with an email verification code</summary>

- [ ] TODO

</details>

<details open>

<summary>Authenticate with a time-based one-time password</summary>

- [ ] TODO

</details>

<details open>

<summary>Authenticate with organization selection</summary>

- [ ] TODO

</details>

#### 3.4 Session tokens

<details open>

<summary>JWKS URL</summary>

- [ ] TODO

</details>

#### 3.5 Authentication errors

<details open>

<summary>Email verification required error</summary>

- [ ] TODO

</details>

<details open>

<summary>MFA enrollment error</summary>

- [ ] TODO

</details>

<details open>

<summary>MFA challenge error</summary>

- [ ] TODO

</details>

<details open>

<summary>Organization selection required error</summary>

- [ ] TODO

</details>

<details open>

<summary>SSO required error</summary>

- [ ] TODO

</details>

<details open>

<summary>Organization authentication required error</summary>

- [ ] TODO

</details>

#### 3.6 Magic Auth

<details open>

<summary>Get a Magic Auth code</summary>

- [ ] TODO

</details>

<details open>

<summary>Create a Magic Auth code</summary>

- [ ] TODO

</details>

#### 3.7 Multi-Factor Authentication

<details open>

<summary>Enroll an authentication factor</summary>

- [ ] TODO

</details>

<details open>

<summary>List authentication factors</summary>

- [ ] TODO

</details>

#### 3.8 Email verification

<details open>

<summary>Get an email verification code</summary>

- [ ] TODO

</details>

#### 3.9 Password reset

<details open>

<summary>Get a password reset token</summary>

- [ ] TODO

</details>

<details open>

<summary>Create a password reset token</summary>

- [ ] TODO

</details>

<details open>

<summary>Reset the password</summary>

- [ ] TODO

</details>


#### 3.10 Organization membership

<details open>

<summary>Get an organization membership</summary>

- [ ] TODO

</details>

<details open>

<summary>List organization memberships</summary>

- [ ] TODO

</details>

<details open>

<summary>Create an organization membership</summary>

- [ ] TODO

</details>

<details open>

<summary>Update an organization membership</summary>

- [ ] TODO

</details>

<details open>

<summary>Delete an organization membership</summary>

- [ ] TODO

</details>

<details open>

<summary>Deactivate an organization membership</summary>

- [ ] TODO

</details>

<details open>

<summary>Reactivate an organization membership</summary>

- [ ] TODO

</details>

#### 3.11 Invitation

<details open>

<summary>Get an invitation</summary>

- [ ] TODO

</details>

<details open>

<summary>Find an invitation by token</summary>

- [ ] TODO

</details>

<details open>

<summary>List invitations</summary>

- [ ] TODO

</details>

<details open>

<summary>Send an invitation</summary>

- [ ] TODO

</details>

<details open>

<summary>Revoke an invitation</summary>

- [ ] TODO

</details>

#### 3.12 Logout

<details open>

<summary>End a user’s session.</summary>

- [ ] TODO

</details>

### 4. Single Sign-On

#### 4.1 Get an authorization URL

- [ ] TODO

#### 4.2 Profile
- [ ] TODO
#### 4.3 Connection
- [ ] TODO

### 5. Directory Sync

#### 5.1 Directory
- [ ] TODO
#### 5.2 Directory User
- [ ] TODO
#### 5.3 Directory Group
- [ ] TODO

### 6. Admin Portal

#### 6.1 Generate a Portal Link
- [ ] TODO

### 7. Audit Logs

#### 7.1 Events
- [ ] TODO
#### 7.2 Schema
- [ ] TODO
#### 7.3 Actions
- [ ] TODO
#### 7.4 Exports
- [ ] TODO
#### 7.4 Retention
- [ ] TODO

### 7. Domain Verification

#### 7.1 Organization domain
- [ ] TODO

### 8. Multi-Factor Auth

#### 8.1 Enroll
- [ ] TODO
#### 8.2 Challenge
- [ ] TODO
#### 8.3 Factor
- [ ] TODO

## Testing

```bash
composer test
```

## Changelog

You can find the changes made in the [repository Releases page](https://github.com/njoguamos/laravel-workos/releases)

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Njogu Amos](https://github.com/njoguamos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
