<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\DTOs\ImpersonatorDTO;

it(description: 'can transform data', closure: function () {
    $dto = new ImpersonatorDTO(
        email: "marcelina.davis@example.com",
        reason: "Debugging user account issue.",
    );

    expect(value: count(value: $dto->array()))->toBe(expected: 2)
        ->and($dto->json())->toBe(json_encode($dto->array()))
        ->and(value: $dto->array())->toBe(expected: [
            "email"  => "marcelina.davis@example.com",
            "reason" => "Debugging user account issue.",
        ]);

});
