<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\DTOs\UserDTO;

it(description: 'can transform data', closure: function () {
    $user = [
        "object"              => "user",
        "id"                  => "user_01E4ZCR3C56J083X43JQXF3JK5",
        "email"               => "marcelina.davis@example.com",
        "email_verified"      => true,
        "created_at"          => "2021-06-25T19:07:33.155Z",
        "updated_at"          => "2021-06-25T19:07:33.155Z",
        "first_name"          => "Marcelina",
        "last_name"           => "Davis",
        "profile_picture_url" => "https://workoscdn.com/images/v1/123abc",
    ];

    $dto = new UserDTO(
        object: $user['object'],
        id: $user['id'],
        email: $user['email'],
        email_verified: $user['email_verified'],
        created_at: $user['created_at'],
        updated_at: $user['updated_at'],
        first_name: $user['first_name'],
        last_name: $user['last_name'],
        profile_picture_url: $user['profile_picture_url'],
    );

    expect(value: count(value: $dto->array()))->toBe(expected: 9)
        ->and($dto->json())->toBe(json_encode($dto->array()))
        ->and(value: $dto->array())->toBe(expected: $user);
});
