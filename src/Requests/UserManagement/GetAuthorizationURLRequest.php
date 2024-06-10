<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Requests\UserManagement;

use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Exceptions\WorkosRequestException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetAuthorizationURLRequest extends Request
{
    protected Method $method = Method::GET;

    protected array $errors = [
        'access_denied', 'ambiguous_connection_selector', 'connection_invalid', 'connection_strategy_invalid',
        'connection_unlinked', 'invalid_connection_selector', 'organization_invalid', 'oauth_failed',
        'server_error', 'client-id-invalid', 'redirect-uri-invalid',
    ];

    public function __construct(
        protected readonly string $client_id,
        protected readonly Provider $provider,
        protected readonly string $redirectUri,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/user_management/authorize';
    }

    protected function defaultQuery(): array
    {
        return [
            'response_type' => "code", // The only valid option
            'client_id'     => $this->client_id,
            'provider'      => $this->provider->value,
            'redirect_uri'  => $this->redirectUri,
        ];
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        foreach ($this->errors as $error) {
            if (str_contains(haystack: $response->getPsrResponse()->getHeaderLine('Location'), needle: $error)) {
                throw WorkosRequestException::create(
                    message: trans(key: 'workos::workos.exceptions.' . str_replace(search: "-", replace: "_", subject: $error))
                );
            }
        }

        return true;
    }
}
