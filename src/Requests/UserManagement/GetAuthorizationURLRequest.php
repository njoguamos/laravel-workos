<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Requests\UserManagement;

use NjoguAmos\LaravelWorkos\DTOs\AuthorizationRequestDTO;
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

    public function __construct(public AuthorizationRequestDTO $dto, public string $client_id)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/user_management/authorize';
    }

    protected function defaultQuery(): array
    {
        return [...$this->dto->filled(), 'client_id' => $this->client_id];
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
