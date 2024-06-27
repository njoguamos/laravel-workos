<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkOS\DTOs\AuthUserDTO;
use NjoguAmos\LaravelWorkOS\DTOs\UserData;
use NjoguAmos\LaravelWorkOS\Enums\AuthMethod;

it(description: 'can transform data', closure: function () {
    $dto = new AuthUserDTO(
        user: new UserData(
            object: "user",
            id: "user_01E4ZCR3C56J083X43JQXF3JK5",
            email: "marcelina.davis@example.com",
            email_verified: true,
            created_at: "2021-06-25T19:07:33.155Z",
            updated_at: "2021-06-25T19:07:33.155Z",
        ),
        access_token: "eyJhb.nNzb19vaWRjX2tleV9.lc5Uk4yWVk5In0",
        refresh_token: "yAjhKk123NLIjdrBdGZPf8pLIDvK",
        authentication_method: AuthMethod::GOOGLE->value,
        organization_id: "org_01H945H0YD4F97JN9MATX7BYAG",
    );

    expect(value: count(value: $dto->array()))->toBe(expected: 6)
        ->and($dto->json())->toBe(json_encode($dto->array()))
        ->and(value: $dto->array())->toBe(expected: [
            'user' => [
                "object"              => "user",
                "id"                  => "user_01E4ZCR3C56J083X43JQXF3JK5",
                "email"               => "marcelina.davis@example.com",
                "email_verified"      => true,
                "created_at"          => "2021-06-25T19:07:33.155Z",
                "updated_at"          => "2021-06-25T19:07:33.155Z",
                'first_name'          => null,
                'last_name'           => null,
                'profile_picture_url' => null,
            ],
            "access_token"          => "eyJhb.nNzb19vaWRjX2tleV9.lc5Uk4yWVk5In0",
            "refresh_token"         => "yAjhKk123NLIjdrBdGZPf8pLIDvK",
            "authentication_method" => AuthMethod::GOOGLE,
            "organization_id"       => "org_01H945H0YD4F97JN9MATX7BYAG",
            'impersonator'          => null,
        ]);

});
