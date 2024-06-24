<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\Enums\GrantType;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\AuthWithCodeRequest;
use Saloon\Enums\Method;

it(description: 'has the correct method', closure: function () {
    $request = new AuthWithCodeRequest(
        code: '01J08K4D6QH4WDP6M3BF3C36HT',
        grant_type: GrantType::CODE
    );

    expect(value: $request->getMethod())->toBe(expected: Method::POST);
});

it(description: 'has the correct endpoint', closure: function () {
    $request = new AuthWithCodeRequest(
        code: '01J15DJBAYME3MM818HBF8RX94',
        grant_type: GrantType::CODE
    );

    expect(value: $request->resolveEndpoint())->toBe(expected: '/user_management/authenticate');
});

it(description: 'has the correct body', closure: function () {
    $code = '01J15DNAQC6RDRXBFBZ9XFNV6B';

    $request = new AuthWithCodeRequest(
        code: $code,
        grant_type: GrantType::CODE
    );

    expect(value: $request->body()->all())->toBe(expected: [
        "code"       => $code,
        "grant_type" => GrantType::CODE->value
  ]);
});
