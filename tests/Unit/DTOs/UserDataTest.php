<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use NjoguAmos\LaravelWorkOS\DTOs\UserData;
use NjoguAmos\LaravelWorkOS\Tests\Unit\Factories\UserFactory;

it(description: 'can transform data', closure: function () {
    $user = UserFactory::create();

    $dto = new UserData(
        object: \NjoguAmos\LaravelWorkOS\Enums\WorkOSObject::from($user['object']),
        id: $user['id'],
        email: $user['email'],
        email_verified: $user['email_verified'],
        created_at: CarbonImmutable::parse($user['created_at']),
        updated_at: CarbonImmutable::parse($user['updated_at']),
        first_name: $user['first_name'],
        last_name: $user['last_name'],
        profile_picture_url: $user['profile_picture_url'],
    );

    expect(value: $dto->array())->toMatchArray($user)
        ->and($dto->json())->toBe(json_encode($dto->array()));
});
