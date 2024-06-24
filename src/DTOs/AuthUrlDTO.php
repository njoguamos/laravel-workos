<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\DTOs;

use NjoguAmos\LaravelWorkos\Contracts\Arrayable;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Traits\Responses\HasResponse;

class AuthUrlDTO implements WithResponse, Arrayable
{
    use HasResponse;

    /**
     * @link https://workos.com/docs/reference/user-management/authentication/get-authorization-url
     */
    public function __construct(
        public readonly string $url,
        public readonly Provider $provider,
    ) {
    }

    public function array(): array
    {
        return [
            'url'      => $this->url,
            'provider' => $this->provider,
        ];
    }

    public function json(): string|false
    {
        return json_encode($this->array());
    }
}
