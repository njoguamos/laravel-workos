<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Requests\UserManagement;

use JsonException;
use NjoguAmos\LaravelWorkos\DTOs\UserDTO;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/user_management/users/{$this->id}";
    }


    public function hasRequestFailed(Response $response): ?bool
    {
        // @TODO: Throw an error when user is not found
        return false;
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();

        return new UserDTO(
            object: $data['object'],
            id: $data['id'],
            email: $data['email'],
            email_verified: $data['email_verified'],
            created_at: $data['created_at'],
            updated_at: $data['updated_at'],
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            profile_picture_url: $data['profile_picture_url'] ?? null,
        );
    }
}
