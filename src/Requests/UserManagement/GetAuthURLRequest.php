<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Requests\UserManagement;

use NjoguAmos\LaravelWorkos\DTOs\AuthUrlDTO;
use Saloon\Enums\Method;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Limit;

class GetAuthURLRequest extends Request
{
    protected Method $method = Method::GET;

    protected array $errors = [
        'access_denied', 'ambiguous_connection_selector', 'connection_invalid', 'connection_strategy_invalid',
        'connection_unlinked', 'invalid_connection_selector', 'organization_invalid', 'oauth_failed',
        'server_error', 'client-id-invalid', 'redirect-uri-invalid', 'code_challenge_missing'
    ];

    public function __construct(protected AuthUrlDTO $dto, protected string $client_id)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/user_management/authorize';
    }

    protected function defaultQuery(): array
    {
        return [
            ...$this->dto->getFilledData(),
            'response_type' => "code",
            'client_id'     => $this->client_id,
        ];
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        foreach ($this->errors as $error) {
            if (str_contains(haystack: $response->getPsrResponse()->getHeaderLine('Location'), needle: $error)) {
                throw new RequestException(
                    response: $response,
                    message: trans(key: 'workos::workos.exceptions.' . str_replace(search: "-", replace: "_", subject: $error))
                );
            }
        }

        // Any response other than a redirect should be treated as an error.
        return ! $response->redirect();
    }

    /**
     * @link https://workos.com/docs/reference/rate-limits
     */
    protected function resolveLimits(): array
    {
        return [
            Limit::allow(requests: 10)->everyMinute(),
        ];
    }
}
