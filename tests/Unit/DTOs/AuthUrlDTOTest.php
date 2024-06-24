<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\DTOs\AuthUrlDTO;
use NjoguAmos\LaravelWorkos\Enums\Provider;

it(description: 'can transform data', closure: function () {
    $dto = new AuthUrlDTO(
        url: 'https://example.com',
        provider: Provider::GITHUB,
    );

    expect(value: $dto->array())->toBe(expected: [
        'url'      => 'https://example.com',
        'provider' => Provider::GITHUB
    ])->and($dto->json())->toBe(json_encode($dto->array()));
});
