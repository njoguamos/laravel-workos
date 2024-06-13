<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\DTOs;

use NjoguAmos\LaravelWorkos\Contracts\Arrayable;

class impersonatorDTO implements Arrayable
{
    /**
     * @link https://workos.com/docs/reference/user-management/authentication/code
     */
    public function __construct(
        public readonly string $email,
        public readonly ?string $reason = null
    ) {
    }

    public function array(): array
    {
        return [
            'email'  => $this->email,
            'reason' => $this->reason,
        ];
    }

    public function json(): string|false
    {
        return json_encode($this->array());
    }
}
