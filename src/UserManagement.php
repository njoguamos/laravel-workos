<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS;

use NjoguAmos\LaravelWorkOS\Connectors\WorkosConnector;
use NjoguAmos\LaravelWorkOS\DTOs\AuthUrlDTO;
use NjoguAmos\LaravelWorkOS\DTOs\AuthUserDTO;
use NjoguAmos\LaravelWorkOS\DTOs\UserData;
use NjoguAmos\LaravelWorkOS\Enums\GrantType;
use NjoguAmos\LaravelWorkOS\Enums\Provider;
use NjoguAmos\LaravelWorkOS\Enums\ScreenHint;
use NjoguAmos\LaravelWorkOS\Requests\AuthWithCodeRequest;
use NjoguAmos\LaravelWorkOS\Requests\GetAuthURLRequest;
use NjoguAmos\LaravelWorkOS\Requests\GetUserRequest;
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
    public function getUser(string $id): UserData
    {
        return $this->getDtoOrFail(request: new GetUserRequest(id: $id));
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getAuthorizationURL(
        string $provider,
        string $redirect_uri,
        string $response_type = "code",
        ?string $code_challenge = null,
        ?string $code_challenge_method = null, // The only valid PKCE code challenge value is "S256"
        ?string $connection_id = null,
        ?string $organization_id = null,
        ?string $state = null,
        ?string $login_hint = null,
        ?string $domain_hint = null,
        ?string $screen_hint = null,
    ): AuthUrlDTO {
        $request = new GetAuthURLRequest(
            client_id: $this->connector->getClientId(),
            provider: $provider ? Provider::from(value: $provider) : null,
            redirect_uri: $redirect_uri,
            response_type: $response_type,
            code_challenge: $code_challenge,
            code_challenge_method: $code_challenge_method,
            connection_id: $connection_id,
            organization_id: $organization_id,
            state: $state,
            login_hint: $login_hint,
            domain_hint: $domain_hint,
            screen_hint: $screen_hint ? ScreenHint::from(value: $screen_hint) : null,
        );

        // Remove authorization header
        $this->connector->headers()->remove(key: 'Authorization');

        return $this->getDtoOrFail(request: $request);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function authenticateWithCode(
        string $code,
        ?string $invitation_code = null,
        ?string $ip_address = null,
        ?string $user_agent = null
    ): AuthUserDTO {
        $request = new AuthWithCodeRequest(
            code: $code,
            grant_type: GrantType::CODE,
            invitation_code: $invitation_code,
            ip_address: $ip_address,
            user_agent: $user_agent
        );

        $request->body()->merge($this->connector->getCredentials());

        return $this->getDtoOrFail(request: $request);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    protected function getDtoOrFail(Request $request): mixed
    {
        return $this->sendRequest(request: $request)->dtoOrFail();
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
