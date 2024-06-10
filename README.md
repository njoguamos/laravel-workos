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

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-workos-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-workos-config"
```

## Usage

### 1. Events

<details>

<summary>List events</summary>

- [ ] TODO

</details>

### 2. Organization

<details>

<summary>Get an Organization</summary>

- [ ] TODO

</details>

<details>

<summary>List Organizations</summary>

- [ ] TODO

</details>

<details>

<summary>Create an Organization</summary>

- [ ] TODO

</details>

<details>

<summary>Update an Organization</summary>

- [ ] TODO

</details>

<details>

<summary>Delete an Organization</summary>

- [ ] TODO

</details>

### 3. User Management

#### 3.1 User Management
<details>

<summary>Get a user</summary>

- [ ] TODO

</details>

<details>

<summary>List users</summary>

- [ ] TODO

</details>

<details>

<summary>Create a user</summary>

- [ ] TODO

</details>

<details>

<summary>Update a user</summary>

- [ ] TODO

</details>

<details>

<summary>Delete a user</summary>

- [ ] TODO

</details>

#### 3.2 Identities

<details>

<summary>Get user identities</summary>

- [ ] TODO

</details>

#### 3.3 Authentication

<details>

<summary>Get an authorization URL</summary>

- [ ] TODO

</details>

<details>

<summary>Authenticate with code</summary>

- [ ] TODO

</details>

<details>

<summary>Authenticate a user with password</summary>

- [ ] TODO

</details>

<details>

<summary>Authenticate with Magic Auth</summary>

- [ ] TODO

</details>

<details>

<summary>Authenticate with refresh token</summary>

- [ ] TODO

</details>

<details>

<summary>Authenticate with an email verification code</summary>

- [ ] TODO

</details>

<details>

<summary>Authenticate with a time-based one-time password</summary>

- [ ] TODO

</details>

<details>

<summary>Authenticate with organization selection</summary>

- [ ] TODO

</details>

#### 3.4 Session tokens

<details>

<summary>JWKS URL</summary>

- [ ] TODO

</details>

#### 3.5 Authentication errors

<details>

<summary>Email verification required error</summary>

- [ ] TODO

</details>

<details>

<summary>MFA enrollment error</summary>

- [ ] TODO

</details>

<details>

<summary>MFA challenge error</summary>

- [ ] TODO

</details>

<details>

<summary>Organization selection required error</summary>

- [ ] TODO

</details>

<details>

<summary>SSO required error</summary>

- [ ] TODO

</details>

<details>

<summary>Organization authentication required error</summary>

- [ ] TODO

</details>

#### 3.6 Magic Auth

<details>

<summary>Get a Magic Auth code</summary>

- [ ] TODO

</details>

<details>

<summary>Create a Magic Auth code</summary>

- [ ] TODO

</details>

#### 3.7 Multi-Factor Authentication

<details>

<summary>Enroll an authentication factor</summary>

- [ ] TODO

</details>

<details>

<summary>List authentication factors</summary>

- [ ] TODO

</details>

#### 3.8 Email verification

<details>

<summary>Get an email verification code</summary>

- [ ] TODO

</details>

#### 3.9 Password reset

<details>

<summary>Get a password reset token</summary>

- [ ] TODO

</details>

<details>

<summary>Create a password reset token</summary>

- [ ] TODO

</details>

<details>

<summary>Reset the password</summary>

- [ ] TODO

</details>


#### 3.10 Organization membership

<details>

<summary>Get an organization membership</summary>

- [ ] TODO

</details>

<details>

<summary>List organization memberships</summary>

- [ ] TODO

</details>

<details>

<summary>Create an organization membership</summary>

- [ ] TODO

</details>

<details>

<summary>Update an organization membership</summary>

- [ ] TODO

</details>

<details>

<summary>Delete an organization membership</summary>

- [ ] TODO

</details>

<details>

<summary>Deactivate an organization membership</summary>

- [ ] TODO

</details>

<details>

<summary>Reactivate an organization membership</summary>

- [ ] TODO

</details>

#### 3.11 Invitation

<details>

<summary>Get an invitation</summary>

- [ ] TODO

</details>

<details>

<summary>Find an invitation by token</summary>

- [ ] TODO

</details>

<details>

<summary>List invitations</summary>

- [ ] TODO

</details>

<details>

<summary>Send an invitation</summary>

- [ ] TODO

</details>

<details>

<summary>Revoke an invitation</summary>

- [ ] TODO

</details>

#### 3.12 Logout

<details>

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

### 8.. Multi-Factor Auth

#### 8..1 Enroll
- [ ] TODO
#### 8..2 Challenge
- [ ] TODO
#### 8..3 Factor
- [ ] TODO

## Testing

```bash
composer test
```

## Changelog

@TODO: Add a link to the changelog file.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Njogu Amos](https://github.com/njoguamos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
