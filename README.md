>*warning*: This package is still under development and not ready for production use.

# A fluent Laravel package for interacting with WorkOS API.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/njoguamos/laravel-workos.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-workos)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-workos/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/njoguamos/laravel-workos/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-workos/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/njoguamos/laravel-workos/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/njoguamos/laravel-workos.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-workos)

@TODO: Add package description here.

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

### 1. User Management

#### 1.1 User
- [ ] TODO
#### 1.2 Identities
- [ ] TODO
#### 1.3 Authentication
- [ ] TODO
#### 1.4 Session tokens
- [ ] TODO
#### 1.5 Authentication errors
- [ ] TODO
#### 1.6 Magic Auth
- [ ] TODO
#### 1.7 Multi-Factor Authentication
- [ ] TODO
#### 1.8 Email verification
- [ ] TODO
#### 1.9 Password reset
- [ ] TODO
#### 1.10 Organization membership
- [ ] TODO
#### 1.11 Invitation
- [ ] TODO
#### 1.12 Logout
- [ ] TODO

### 2. Single Sign-On

#### 2.1 Get an authorization URL
- [ ] TODO
#### 2.2 Profile
- [ ] TODO
#### 2.3 Connection
- [ ] TODO

### 3. Directory Sync

#### 3.1 Directory
- [ ] TODO
#### 3.2 Directory User
- [ ] TODO
#### 3.3 Directory Group
- [ ] TODO

### 4. Admin Portal

#### 4.1 Generate a Portal Link
- [ ] TODO

### 5. Audit Logs

#### 5.1 Events
- [ ] TODO
#### 5.2 Schema
- [ ] TODO
#### 5.3 Actions
- [ ] TODO
#### 5.4 Exports
- [ ] TODO
#### 5.4 Retention
- [ ] TODO

### 6. Domain Verification

#### 6.1 Organization domain
- [ ] TODO

### 7.Multi-Factor Auth

#### 7.1 Enroll
- [ ] TODO
#### 7.2 Challenge
- [ ] TODO
#### 7.3 Factor
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
