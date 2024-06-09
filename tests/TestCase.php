<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use NjoguAmos\LaravelWorkos\LaravelWorkosServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'NjoguAmos\\LaravelWorkos\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelWorkosServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('workos.api_key', 'sk_test_1234567890');
        config()->set('workos.client_id', 'client_1234567890');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-workos_table.php.stub';
        $migration->up();
        */
    }
}
