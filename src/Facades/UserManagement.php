<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NjoguAmos\LaravelWorkos\UserManagement
 */
class UserManagement extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NjoguAmos\LaravelWorkos\UserManagement::class;
    }
}
