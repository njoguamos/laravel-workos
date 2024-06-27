<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Exceptions;

use InvalidArgumentException;

final class ApiKeyIsMissing extends InvalidArgumentException
{
    /**
     * Create a new exception instance.
     */
    public static function create(): self
    {
        return new self(
            message: trans(
                key: 'workos::workos.exceptions.api_key_is_missing'
            )
        );
    }
}
