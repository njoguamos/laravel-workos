<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\DTOs\AuthUrlDTO;
use NjoguAmos\LaravelWorkos\Enums\Provider;

it(description: 'can get filled data', closure: function () {
    $dto = new AuthUrlDTO(
        provider: Provider::GOOGLE,
        redirect_uri: "http://localhost:8000/auth/callback",
    );

    expect(value: count(value: $dto->getFilledData()))->toBe(expected: 2)
        ->and(value: $dto->getFilledData())->toBe(expected: [
            'provider'     => Provider::GOOGLE->value,
            'redirect_uri' => "http://localhost:8000/auth/callback",
        ]);
});
