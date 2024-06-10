<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Exceptions;

use RuntimeException;

final class WorkosRequestException extends RuntimeException
{
    /**
     * Create a new exception instance.
     */
    public static function create(string $message): self
    {
        return new self(message: $message);
    }
}
