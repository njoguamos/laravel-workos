<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Requests\UserManagement;

use JsonException;
use NjoguAmos\LaravelWorkos\DTOs\AuthUserDTO;
use NjoguAmos\LaravelWorkos\DTOs\CodeAuthDTO;
use NjoguAmos\LaravelWorkos\DTOs\impersonatorDTO;
use NjoguAmos\LaravelWorkos\DTOs\UserDTO;
use NjoguAmos\LaravelWorkos\Enums\GrantType;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Limit;
use Saloon\Traits\Body\HasJsonBody;

class AuthWithCodeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected CodeAuthDTO $dto)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/user_management/authenticate';
    }

    protected function defaultBody(): array
    {
        return [
            ...$this->dto->getFilledData(),
            'grant_type' => GrantType::CODE->value,
        ];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();
        $user = $data['user'];

        return new AuthUserDTO(
            user: new UserDTO(
                object: $user['object'],
                id: $user['id'],
                email: $user['email'],
                email_verified: $user['email_verified'],
                created_at: $user['created_at'],
                updated_at: $user['updated_at'],
                first_name: $user['first_name'],
                last_name: $user['last_name'],
                profile_picture_url: $user['profile_picture_url'],
            ),
            access_token: $data['access_token'],
            refresh_token: $data['refresh_token'],
            authentication_method: $data['authentication_method'],
            organization_id: $data['organization_id'],
            impersonator: isset($data['impersonator']) ? new impersonatorDTO(
                email: $data['impersonator']['email'],
                reason: $data['impersonator']['reason'],
            ) : null,
        );
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
