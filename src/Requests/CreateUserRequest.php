<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Requests;

use JsonException;
use NjoguAmos\LaravelWorkOS\Concerns\FillableData;
use NjoguAmos\LaravelWorkOS\Contracts\Fillable;
use NjoguAmos\LaravelWorkOS\DTOs\UserData;
use NjoguAmos\LaravelWorkOS\Enums\PasswordHashType;
use NjoguAmos\LaravelWorkOS\Enums\WorkOSObject;
use NjoguAmos\LaravelWorkOS\Services\DateParser;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateUserRequest extends Request implements Fillable, HasBody
{
    use HasJsonBody;
    use FillableData;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string $email,
        public readonly ?string $password = null,
        public readonly ?string $password_hash = null,
        public readonly ?PasswordHashType $password_hash_type = null,
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?bool $email_verified = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/user_management/users/";
    }

    protected function defaultBody(): array
    {
        return $this->getFilledData(except: ['method']);
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();

        return new UserData(
            object: WorkOSObject::from(value: $data['object']),
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
