<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\DTOs;

use NjoguAmos\LaravelWorkos\Concerns\FillableData;
use NjoguAmos\LaravelWorkos\Contracts\Fillable;

class CodeAuthDTO extends BaseDTO implements Fillable
{
    use FillableData;

    /**
     * @link https://workos.com/docs/reference/user-management/authentication/code
     */
    public function __construct(
        public readonly string $code,
        public readonly ?string $invitation_code = null,
        public readonly ?string $ip_address = null,
        public readonly ?string $user_agent = null,
    ) {
    }
}
