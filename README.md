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

```php
# TODO
```

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
