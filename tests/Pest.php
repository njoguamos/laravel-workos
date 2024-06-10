<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\Tests\TestCase;
use Saloon\Http\Faking\MockClient;
use Saloon\MockConfig;

uses(TestCase::class)
    ->beforeEach(hook: fn () => MockClient::destroyGlobal())
    ->in(__DIR__);


MockConfig::setFixturePath(path: 'tests/Fixtures');
