<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\DTOs;

use NjoguAmos\LaravelWorkos\Contracts\Arrayable;
use NjoguAmos\LaravelWorkos\Enums\AuthMethod;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Traits\Responses\HasResponse;

class AuthUserDTO implements WithResponse, Arrayable
{
    use HasResponse;

    /**
     * @link https://workos.com/docs/reference/user-management/user
     */
    public function __construct(
        public readonly UserDTO          $user,
        public readonly string           $access_token,
        public readonly string           $refresh_token,
        public readonly AuthMethod | string $authentication_method,
        public readonly ?string          $organization_id = null,
        public readonly ?ImpersonatorDTO $impersonator = null,
    ) {
    }

    public function array(): array
    {
        return [
            'user'                  => $this->user->array(),
            'access_token'          => $this->access_token,
            'refresh_token'         => $this->refresh_token,
            'authentication_method' => is_string($this->authentication_method)
                ? AuthMethod::from($this->authentication_method)
                : $this->authentication_method,
            'organization_id' => $this->organization_id ?? null,
            'impersonator'    => $this->impersonator?->array(),
        ];
    }

    public function json(): string|false
    {
        return json_encode($this->array());
    }
}
