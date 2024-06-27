<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkOS\Tests\TestCase;
use Saloon\Http\Faking\MockClient;

uses(TestCase::class)
    ->beforeEach(hook: fn () => MockClient::destroyGlobal())
    ->in(__DIR__);
