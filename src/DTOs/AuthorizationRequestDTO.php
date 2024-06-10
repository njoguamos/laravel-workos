<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\DTOs;

use NjoguAmos\LaravelWorkos\Concerns\FillableData;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Enums\ScreenHint;
use Spatie\LaravelData\Data;

class AuthorizationRequestDTO extends Data
{
    use FillableData;

    /**
     * @see https://workos.com/docs/reference/user-management/authentication/get-authorization-url
     */
    public function __construct(
        public readonly Provider $provider,
        public readonly string $redirect_uri,
        public readonly string  $response_type = "code",  // The only valid option is 'code'
        public readonly ?string $code_challenge = null,
        public readonly ?string $code_challenge_method = null, // The only valid PKCE code challenge value is
        public readonly ?string $connection_id = null,
        public readonly ?string $organization_id = null,
        public readonly ?string $state = null,
        public readonly ?string $login_hint = null,
        public readonly ?string $domain_hint = null,
        public readonly ?ScreenHint $screen_hint = null,
    ) {
    }

    public function resolved(): array
    {
        return [
         ...$this->filled(),
                'provider'    => $this->provider->value,
                'screen_hint' => $this->screen_hint?->value,
        ];
    }
}
