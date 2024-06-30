<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Tests\Factories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use NjoguAmos\LaravelWorkOS\Enums\AuthMethod;

class AuthUserFactory
{
    public static function create(array $data = []): array
    {
        $user = (new UserFactory())->create();

        return array_merge([
            "user"                  => $user,
            "access_token"          => Str::random(48),
            "refresh_token"         => Str::random(),
            "authentication_method" => Arr::random(AuthMethod::cases())->value,
            "organization_id"       => "org_".Str::ulid(),
            "impersonator"          => null
        ], $data);
    }
}
