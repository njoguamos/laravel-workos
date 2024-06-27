<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Connectors;

use Illuminate\Support\Facades\Cache;
use NjoguAmos\LaravelWorkOS\Exceptions\RateLimitReachedException;
use NjoguAmos\LaravelWorkOS\Exceptions\WorkOSRequestException;
use NjoguAmos\LaravelWorkOS\WorkOSSDK;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Throwable;

class WorkOSConnector extends Connector
{
    use AlwaysThrowOnErrors;
    use HasRateLimits;

    public function __construct(
        #[\SensitiveParameter]
        protected readonly string $apiKey,
        #[\SensitiveParameter]
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

    public function defaultHeaders(): array
    {
        return [
            'User-Agent' => WorkOSSDK::IDENTIFIER . ' / ' . WorkOSSDK::VERSION. ' | ' . WorkOSSDK::WEBSITE,
        ];
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

    public function getRequestException(Response $response, ?Throwable $senderException): WorkOSRequestException
    {
        return (new WorkOSExceptionResolver())->getRequestException($response, $senderException);
    }

    protected function throwLimitException(Limit $limit): void
    {
        throw new RateLimitReachedException(
            message: trans(key: 'workos::workos.errors.429')
        );
    }
}
