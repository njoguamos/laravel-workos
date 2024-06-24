<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Connectors;

use Illuminate\Support\Facades\Cache;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Throwable;

class WorkosConnector extends Connector
{
    use AlwaysThrowOnErrors;
    use HasRateLimits;

    public function __construct(
        protected readonly string $apiKey,
        protected readonly string $clientId,
        protected readonly string $apiBaseurl,
    ) {
    }

    public function resolveBaseurl(): string
    {
        return $this->apiBaseurl;
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->apiKey);
    }

    public function defaultConfig(): array
    {
        return [
            'allow_redirects' => false,
        ];
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getApiBaseurl(): string
    {
        return $this->apiBaseurl;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getCredentials(): array
    {
        return [
            'client_id'     => $this->getClientId(),
            'client_secret' => $this->getApiKey(),
        ];
    }

    /**
     * @link https://workos.com/docs/reference/rate-limits
     */
    protected function resolveLimits(): array
    {
        return [
            Limit::allow(requests: 60000)->everyMinute(),
        ];
    }

    /**
     * User Laravel cache driver to store rate limits
     */
    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new LaravelCacheStore(
            store: Cache::store(config(key: 'workos.cache_store'))
        );
    }

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        return new RequestException(
            response: $response,
            message: $this->getMessage(response: $response),
            code: $response->getPsrResponse()->getStatusCode()
        );
    }

    /**
     * @link https://workos.com/docs/reference/errors
     */
    public function getMessage(Response $response): string
    {
        return match ($response->getPsrResponse()->getStatusCode()) {
            400     => trans(key: 'workos::workos.errors.400'),
            401     => trans(key: 'workos::workos.errors.401'),
            403     => trans(key: 'workos::workos.errors.403'),
            404     => trans(key: 'workos::workos.errors.404'),
            422     => trans(key: 'workos::workos.errors.422'),
            default => $response->getPsrResponse()->getReasonPhrase()
        };
    }
}
