<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Connectors;

use Saloon\Http\Connector;

class WorkosConnector extends Connector
{
    public function __construct(
        public string $apiKey,
        public string $clientId,
        public string $apiBaseurl,
    ) {
    }

    public function resolveBaseurl(): string
    {
        return $this->apiBaseurl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ];
    }
}
