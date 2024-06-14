<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\DTOs;

use NjoguAmos\LaravelWorkos\Concerns\FillableData;
use NjoguAmos\LaravelWorkos\Contracts\Fillable;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Enums\ScreenHint;

class AuthUrlDTO extends BaseDTO implements Fillable
{
    use FillableData;

    /**
     * @link https://workos.com/docs/reference/user-management/authentication/get-authorization-url
     */
    public function __construct(
        public readonly Provider $provider,
        public readonly string $redirect_uri,
        public readonly ?string $code_challenge = null,
        public readonly ?string $code_challenge_method = null, // The only valid PKCE code challenge value is "S256"
        public readonly ?string $connection_id = null,
        public readonly ?string $organization_id = null,
        public readonly ?string $state = null,
        public readonly ?string $login_hint = null,
        public readonly ?string $domain_hint = null,
        public readonly ?ScreenHint $screen_hint = null,
    ) {
    }
}
