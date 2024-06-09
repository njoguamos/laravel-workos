<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos;

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
            ->hasMigration(migrationFileName: 'create_laravel-workos_table')
            ->hasCommand(commandClassName: LaravelWorkosCommand::class);
    }
}
