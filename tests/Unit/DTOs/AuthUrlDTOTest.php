<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\DTOs\CodeAuthDTO;

it(description: 'can get filled data', closure: function () {
    $dto = new CodeAuthDTO(
        code: 'code',
        ip_address: 'ip_address',
        user_agent: 'user_agent'
    );

    expect(value: count(value: $dto->getFilledData()))->toBe(expected: 3)
        ->and(value: $dto->getFilledData())->toBe(expected: [
            'code'       => 'code',
            'ip_address' => 'ip_address',
            'user_agent' => 'user_agent'
        ]);
});
