<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos;

use NjoguAmos\LaravelWorkos\Connectors\WorkosConnector;
use NjoguAmos\LaravelWorkos\Exceptions\ApiKeyIsMissing;
use NjoguAmos\LaravelWorkos\Exceptions\ClientIdIsMissing;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NjoguAmos\LaravelWorkos\Commands\LaravelWorkosCommand;

class LaravelWorkosServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name(name: 'laravel-workos')
            ->hasConfigFile(configFileName: 'workos')
            ->hasTranslations()
            ->hasMigration(migrationFileName: 'create_laravel-workos_table')
            ->hasCommand(commandClassName: LaravelWorkosCommand::class);
    }

    public function registeringPackage(): void
    {
        $this->app->bind(abstract: WorkosConnector::class, concrete: function ($app) {
            $config = $app['config']->get('workos');

            $apiKey = $config['api_key'];
            $clientId = $config['client_id'];

            if (empty($apiKey)) {
                throw ApiKeyIsMissing::create();
            }

            if (empty($clientId)) {
                throw ClientIdIsMissing::create();
            }

            return new WorkosConnector(
                apiKey: $apiKey,
                clientId: $config['client_id'],
                apiBaseurl: $config['api_base_url']
            );
        });
    }
}
