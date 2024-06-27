<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NjoguAmos\LaravelWorkOS\UserManagement
 */
class UserManagement extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NjoguAmos\LaravelWorkOS\UserManagement::class;
    }
}
