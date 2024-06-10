<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos;

use NjoguAmos\LaravelWorkos\Connectors\WorkosConnector;
use NjoguAmos\LaravelWorkos\Enums\Provider;
use NjoguAmos\LaravelWorkos\Exceptions\WorkosRequestException;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\GetAuthorizationURLRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class UserManagement
{
    protected WorkosConnector $connector;

    public function __construct()
    {
        $this->connector = app(abstract: WorkosConnector::class);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getAuthorizationURL(Provider $provider, string $redirectUri): string
    {
        $request = new GetAuthorizationURLRequest(
            client_id: $this->connector->clientId(),
            provider: $provider,
            redirectUri: $redirectUri,
        );

        $response = $this->connector->send(request: $request);

        // If response is not a redirect, throw an exception
        if (! $response->redirect()) {
            throw WorkosRequestException::create(
                message: trans(key: 'workos::workos.exceptions.client_id_is_missing')
            );
        }

        $redirectUrl = $response->getPsrResponse()->getHeaderLine('Location');

        return $redirectUrl;
    }
}
