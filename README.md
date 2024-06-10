>*warning*: This package is still under development and not ready for production use.

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
- ✅ Users [Spatie DTOs](https://github.com/spatie/laravel-data/) for efficient data handling
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


<details open>

<summary>Get an authorization URL</summary>

To get the authorization URL, call the `getAuthorizationURL` method of `UserManagement` class. The method accepts an instance of `AuthorizationRequestDTO` as an argument. 

```php
use NjoguAmos\LaravelWorkos\DTOs\AuthorizationRequestDTO;
use NjoguAmos\LaravelWorkos\UserManagement;
use NjoguAmos\LaravelWorkos\Enums\Provider;

$dto = new AuthorizationRequestDTO(
    provider: Provider::GOOGLE,
    redirect_uri: 'http://localhost:3000/callback',
);

$url = (new UserManagement())->getAuthorizationURL($dto);
```

 You should redirect your users to `response URL` to complete the authentication. 

```text
https://accounts.google.com/o/oauth2/v2/auth?access_type=offline&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&state=eyJhbGciOiJIUzIGHJKDSFSFGGF7.eyJhcGkiOiJ1c2VyX21hbmFnZW1lbnQiLCJyZWRpcmVjdF91cmkiOiJodHRwOi8vbG9jYUYGASFIUFSGUIF76sDFGsjgdytUIYXQiOjE3MTgwMzY4NTMsImV4cCI6MTcxODAzNzc1M30.XVLCkLerRvwuVzC_Qrugbi3mzN36g8ROJQKiGGVOL8w&response_type=code&client_id=107873717349-glhtihlrvlblbs4u94teon3o5fcqb79f.apps.googleusercontent.com&redirect_uri=https%3A%2F%2Fauth.workos.com%2Fsso%2Foauth%2Fgoogle%2FLIDju2jt3JCqKGExIexjgOSQ1%2Fcallback
```

Here is practical example on a laravel application

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use NjoguAmos\LaravelWorkos\DTOs\AuthorizationRequestDTO;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Facades\UserManagement;

class AuthorizationUrlController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'provider'     => ['required', Rule::enum(type: Provider::class)],
            'redirect_uri' => ['required', 'url'],
        ]);

        try {
            $dto = new AuthorizationRequestDTO(
                provider: $validated['provider'],
                redirect_uri: $validated['redirect_uri'],
            );

            $url = UserManagement::getAuthorizationURL($dto);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new \RuntimeException(
                message: "Unable to generate authorization URL fro for `{$validated['provider']}`. Please try again later.",
            );
        }

        // You have the URL here, you can
        // - return it to the client as json response
        // - return the URL as in view
        // - redirect the user to the url
        return redirect()->away($url);
    }
}
```

> **Note**: The `AuthorizationRequestDTO` class accepts the following parameters: `provider`, `redirect_uri`, `response_type`, `code_challenge`, `code_challenge_method`, `connection_id`, `organization_id`, `state`, `login_hint`, `domain_hint` and `screen_hint`. Learn more form the [official documentation](https://workos.com/docs/reference/user-management/authentication/get-authorization-url).

>**Info**: This package will automatically throw exception [authorization URL errors](https://workos.com/docs/reference/user-management/authentication/get-authorization-url/error-codes). The error messages are descriptive so that you know what went wrong.


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

This package uses fixtures to test the API. These fixtures have been generated by running running real API call and saving the response in the `tests/Fixtures` directory.

These fixtures are close to the real API response as opposed to mocking a fake response. 

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
