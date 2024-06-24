> [!CAUTION]
> This package is still under development and not ready for production use.

# A fluent Laravel package for interacting with WorkOS API.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/njoguamos/laravel-workos.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-workos)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-workos/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/njoguamos/laravel-workos/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-workos/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/njoguamos/laravel-workos/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/njoguamos/laravel-workos.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-workos)

@TODO: Add package description here.

## Why use This package?

- ✅ The package has been optimised for Laravel 10+.
- ✅ Offer developer friendly error handling e.g. `Get an authorization URL Errors`.
- ✅ Offers language translations .
- ✅ Build with [Saloon PHP](https://docs.saloon.dev). This mean you can benefit from Saloon goodies such as [Laravel Plugin](https://docs.saloon.dev/installable-plugins/laravel-integration) which can debug the WorkOS API requests inside your Laravel application.
- ✅ Users Data Object Transfer for efficient data handling. DTO are powered by [Spatie laravel data](https://spatie.be/docs/laravel-data).
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

## Documentation

The documentation is available at [https://njoguamos.github.io/laravel-workos](https://njoguamos.github.io/laravel-workos).






The response is a `AuthUserDTO` object which can be used as an `object` or converted to `json` or `array`.

```php
$json = $response->json()
```

Output

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

If the authentication did not succeed, WorkOS API will return a a `400` or `403` error which will be thrown as a `\Saloon\Exceptions\Request\RequestException`.

- `400` error occurs when the authentication code is invalid or expired.
- `403` occur when WorkOS returns predefined [Authentication errors](https://workos.com/docs/reference/user-management/authentication-errors), which include `email_verification_required`, `mfa_enrollment`, `mfa_challenge`, `organization_selection_required`, `sso_required`, and `organization_authentication_methods_required`.

You can use try and catch block to handle the errors. Example you can determine if body contains `email_verification_required` and redirect user to email verification page.

```php

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
- [Brian Kariuki](https://github.com/BrianKariukiDev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
