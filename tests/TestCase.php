<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use NjoguAmos\LaravelWorkOS\WorkOSServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'NjoguAmos\\LaravelWorkOS\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            WorkOSServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('app.timezone', 'Africa/Nairobi');
        config()->set('database.default', 'testing');
        config()->set('workos.api_key', 'sk_test_123456789');
        config()->set('workos.client_id', 'client_123456789');
    }
}
