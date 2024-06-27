<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\DTOs;

use NjoguAmos\LaravelWorkOS\Contracts\Transformers;

final class ImpersonatorDTO implements Transformers
{
    /**
     * @link https://workos.com/docs/reference/user-management/authentication/code
     */
    public function __construct(
        public readonly string  $email,
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
