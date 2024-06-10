<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos;

use NjoguAmos\LaravelWorkos\Connectors\WorkosConnector;
use NjoguAmos\LaravelWorkos\DTOs\AuthorizationRequestDTO;
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
    public function getAuthorizationURL(AuthorizationRequestDTO $dto): string
    {
        $request = new GetAuthorizationURLRequest(dto: $dto, client_id: $this->connector->getClientId());

        $response = $this->connector->send(request: $request);

        // TODO: Consider handling non 3xx responses

        return $response->getPsrResponse()->getHeaderLine('Location');
    }
}
