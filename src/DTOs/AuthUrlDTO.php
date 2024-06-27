<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\DTOs;

use NjoguAmos\LaravelWorkOS\Contracts\Transformers;
use NjoguAmos\LaravelWorkOS\Enums\Provider;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Traits\Responses\HasResponse;

final class AuthUrlDTO implements WithResponse, Transformers
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
