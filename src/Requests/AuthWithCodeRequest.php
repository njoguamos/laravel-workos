<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Requests;

use JsonException;
use NjoguAmos\LaravelWorkOS\Concerns\FillableData;
use NjoguAmos\LaravelWorkOS\Contracts\Fillable;
use NjoguAmos\LaravelWorkOS\DTOs\AuthUserDTO;
use NjoguAmos\LaravelWorkOS\DTOs\ImpersonatorDTO;
use NjoguAmos\LaravelWorkOS\DTOs\UserData;
use NjoguAmos\LaravelWorkOS\Enums\AuthMethod;
use NjoguAmos\LaravelWorkOS\Enums\GrantType;
use NjoguAmos\LaravelWorkOS\Enums\WorkOSObject;
use NjoguAmos\LaravelWorkOS\Services\DateParser;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Limit;
use Saloon\Traits\Body\HasJsonBody;

final class AuthWithCodeRequest extends Request implements HasBody, Fillable
{
    use HasJsonBody;
    use FillableData;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string  $code,
        public readonly GrantType $grant_type,
        public readonly ?string $invitation_code = null,
        public readonly ?string $ip_address = null,
        public readonly ?string $user_agent = null
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/user_management/authenticate';
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
        $user = $data['user'];

        return new AuthUserDTO(
            user: new UserData(
                object: WorkOSObject::from($user['object']),
                id: $user['id'],
                email: $user['email'],
                email_verified: $user['email_verified'],
                created_at: app(abstract: DateParser::class)->parse(timestamp: $user['created_at']),
                updated_at: app(abstract: DateParser::class)->parse(timestamp: $user['updated_at']),
                first_name: $user['first_name'] ?? null,
                last_name: $user['last_name'] ?? null,
                profile_picture_url: $user['profile_picture_url'] ?? null,
            ),
            access_token: $data['access_token'],
            refresh_token: $data['refresh_token'],
            authentication_method: AuthMethod::from(value: $data['authentication_method']),
            organization_id: $data['organization_id'],
            impersonator: isset($data['impersonator']) ? new ImpersonatorDTO(
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
