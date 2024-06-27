<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Requests;

use JsonException;
use NjoguAmos\LaravelWorkOS\DTOs\UserData;
use NjoguAmos\LaravelWorkOS\Enums\WorkOSObject;
use NjoguAmos\LaravelWorkOS\Services\DateParser;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public readonly string $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/user_management/users/$this->id";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): UserData
    {
        $data = $response->json();

        return new UserData(
            object: WorkOSObject::from($data['object']),
            id: $data['id'],
            email: $data['email'],
            email_verified: $data['email_verified'],
            created_at: app(abstract: DateParser::class)->parse(timestamp: $data['created_at']),
            updated_at: app(abstract: DateParser::class)->parse(timestamp: $data['updated_at']),
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            profile_picture_url: $data['profile_picture_url'] ?? null,
        );
    }
}
