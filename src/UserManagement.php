<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS;

use NjoguAmos\LaravelWorkOS\Connectors\WorkOSConnector;
use NjoguAmos\LaravelWorkOS\DTOs\AuthUrlDTO;
use NjoguAmos\LaravelWorkOS\DTOs\AuthUserDTO;
use NjoguAmos\LaravelWorkOS\DTOs\UserData;
use NjoguAmos\LaravelWorkOS\Enums\GrantType;
use NjoguAmos\LaravelWorkOS\Enums\Provider;
use NjoguAmos\LaravelWorkOS\Enums\ScreenHint;
use NjoguAmos\LaravelWorkOS\Exceptions\WorkOSRequestException;
use NjoguAmos\LaravelWorkOS\Requests\AuthWithCodeRequest;
use NjoguAmos\LaravelWorkOS\Requests\CreateUserRequest;
use NjoguAmos\LaravelWorkOS\Requests\GetAuthURLRequest;
use NjoguAmos\LaravelWorkOS\Requests\GetUserRequest;
use Saloon\Http\Request;
use Saloon\Http\Response;

class UserManagement
{
    protected WorkOSConnector $connector;

    public function __construct()
    {
        $this->connector = app(abstract: WorkOSConnector::class);
    }

    /**
     * @throws WorkOSRequestException
     */
    public function getUser(string $id): UserData
    {
        return $this->getDtoOrFail(request: new GetUserRequest(id: $id));
    }

    /**
     * @throws WorkOSRequestException
     */
    public function createUser(
        string  $email,
        ?string $password = null,
        ?string $password_hash = null,
        ?string $password_hash_type = null,
        ?string $first_name = null,
        ?string $last_name = null,
        ?bool   $email_verified = null,
    ): UserData {
        $request = new CreateUserRequest(
            email: $email,
            password: $password,
            password_hash: $password_hash,
            password_hash_type: $password_hash_type,
            first_name: $first_name,
            last_name: $last_name,
            email_verified: $email_verified,
        );

        return $this->getDtoOrFail($request);
    }

    /**
     * @throws WorkOSRequestException
     */
    public function getAuthorizationURL(
        string  $provider,
        string  $redirect_uri,
        string  $response_type = "code",
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
     * @throws WorkOSRequestException
     */
    public function authenticateWithCode(
        string  $code,
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
     * @throws WorkOSRequestException
     */
    protected function getDtoOrFail(Request $request): mixed
    {
        return $this->sendRequest(request: $request)->dtoOrFail();
    }

    /**
     * @throws WorkOSRequestException
     */
    protected function sendRequest(Request $request): Response
    {
        return $this->connector->send(request: $request);
    }
}
