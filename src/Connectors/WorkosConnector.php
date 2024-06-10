<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Connectors;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class WorkosConnector extends Connector
{
    use AlwaysThrowOnErrors;

    public function __construct(
        public readonly string $apiKey,
        public readonly string $clientId,
        public readonly string $apiBaseurl,
    ) {
    }

    public function resolveBaseurl(): string
    {
        return $this->apiBaseurl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json'
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
}
