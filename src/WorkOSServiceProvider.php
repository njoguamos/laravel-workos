<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS;

use NjoguAmos\LaravelWorkOS\Connectors\WorkOSConnector;
use NjoguAmos\LaravelWorkOS\Exceptions\ApiKeyIsMissing;
use NjoguAmos\LaravelWorkOS\Exceptions\ClientIdIsMissing;
use NjoguAmos\LaravelWorkOS\Services\DateParser;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WorkOSServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * @link [More info](https://github.com/spatie/laravel-package-tools)
         */
        $package
            ->name(name: 'laravel-workos')
            ->hasConfigFile(configFileName: 'workos')
            ->hasTranslations();
    }

    public function registeringPackage(): void
    {
        $this->app->bind(abstract: WorkOSConnector::class, concrete: function ($app) {
            $config = $app['config']->get('workos');

            $apiKey = $config['api_key'];
            $clientId = $config['client_id'];

            if (empty($apiKey)) {
                throw ApiKeyIsMissing::create();
            }

            if (empty($clientId)) {
                throw ClientIdIsMissing::create();
            }

            return new WorkOSConnector(
                apiKey: $apiKey,
                clientId: $config['client_id'],
                apiBaseurl: $config['api_base_url']
            );
        });

        $this->app->bind(abstract: DateParser::class, concrete: function ($app) {
            return new DateParser(
                convertToAppTimezone: $app['config']->get('workos')['convert_timezone']
            );
        });
    }
}
