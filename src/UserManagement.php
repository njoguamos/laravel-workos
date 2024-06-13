<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos;

use NjoguAmos\LaravelWorkos\Connectors\WorkosConnector;
use NjoguAmos\LaravelWorkos\DTOs\AuthUserDTO;
use NjoguAmos\LaravelWorkos\DTOs\CodeAuthDTO;
use NjoguAmos\LaravelWorkos\DTOs\AuthUrlDTO;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\AuthWithCodeRequest;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\GetAuthURLRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Request;
use Saloon\Http\Response;

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
    public function getAuthorizationURL(AuthUrlDTO $dto): string
    {
        $request = new GetAuthURLRequest(dto: $dto, client_id: $this->connector->getClientId());

        $response = $this->sendRequest(request: $request);

        return $response->getPsrResponse()->getHeaderLine('Location');
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function authenticateWithCode(CodeAuthDTO $dto): AuthUserDTO
    {
        $request = new AuthWithCodeRequest(dto: $dto);

        $request->body()->merge($this->connector->getCredentials());

        $response = $this->sendRequest(request: $request);

        return $response->dtoOrFail();
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    protected function sendRequest(Request $request): Response
    {
        return $this->connector->send(request: $request);
    }
}
