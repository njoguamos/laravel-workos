<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Exceptions;

use InvalidArgumentException;

final class ClientIdIsMissing extends InvalidArgumentException
{
    /**
     * Create a new exception instance.
     */
    public static function create(): self
    {
        return new self(
            message: trans(
                key: 'workos::workos.exceptions.client_id_is_missing'
            )
        );
    }
}
