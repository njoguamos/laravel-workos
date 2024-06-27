<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Tests\Unit\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use NjoguAmos\LaravelWorkOS\Enums\WorkOSObject;

class UserFactory
{
    public static function create(array $data = []): array
    {
        return array_merge([
            "object"              => WorkOSObject::USER->value,
            "id"                  => "user_".Str::ulid()->toString(),
            "email"               => fake()->unique()->safeEmail(),
            "email_verified"      => fake()->boolean(80),
            "created_at"          => CarbonImmutable::instance(date: fake()->dateTimeThisYear())->format(format: 'Y-m-d\TH:i:s.v\Z'),
            "updated_at"          => CarbonImmutable::instance(date: fake()->dateTimeThisYear())->format(format: 'Y-m-d\TH:i:s.v\Z'),
            "first_name"          => fake()->optional()->firstName(),
            "last_name"           => fake()->optional()->lastName(),
            "profile_picture_url" => fake()->optional()->imageUrl(),
        ], $data);
    }
}
