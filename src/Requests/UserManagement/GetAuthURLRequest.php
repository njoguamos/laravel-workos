<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Requests\UserManagement;

use JsonException;
use NjoguAmos\LaravelWorkos\Concerns\FillableData;
use NjoguAmos\LaravelWorkos\Contracts\Fillable;
use NjoguAmos\LaravelWorkos\DTOs\AuthUrlDTO;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Enums\ScreenHint;
use Saloon\Enums\Method;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Limit;

class GetAuthURLRequest extends Request implements Fillable
{
    use FillableData;

    protected Method $method = Method::GET;

    private array $errors = [
        'access_denied', 'ambiguous_connection_selector', 'connection_invalid', 'connection_strategy_invalid',
        'connection_unlinked', 'invalid_connection_selector', 'organization_invalid', 'oauth_failed',
        'server_error', 'client-id-invalid', 'redirect-uri-invalid', 'code_challenge_missing'
    ];

    public function __construct(
        protected string $client_id,
        public readonly Provider $provider,
        public readonly string $redirect_uri,
        public readonly string $response_type = "code",
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

    public function resolveEndpoint(): string
    {
        return '/user_management/authorize';
    }

    protected function defaultQuery(): array
    {
        return $this->getFilledData(['errors' ,'method']);
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): mixed
    {
        return new AuthUrlDTO(
            url: $response->getPsrResponse()->getHeaderLine('Location'),
            provider: $this->provider
        );
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
