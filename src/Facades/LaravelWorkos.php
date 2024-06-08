<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NjoguAmos\LaravelWorkos\LaravelWorkos
 */
class LaravelWorkos extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NjoguAmos\LaravelWorkos\LaravelWorkos::class;
    }
}
