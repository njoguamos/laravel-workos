<?php

declare(strict_types=1);

use NjoguAmos\LaravelWorkos\Enums\GrantType;
use NjoguAmos\LaravelWorkos\Requests\UserManagement\AuthWithCodeRequest;
use Saloon\Enums\Method;

beforeEach(closure: function () {
    $this->code = '01J08K4D6QH4WDP6M3BF3C36HT';

    $this->request = new AuthWithCodeRequest(code: $this->code);
});

it(description: 'has the correct method', closure: function () {
    expect(value: $this->request->getMethod())->toBe(expected: Method::POST);
});

it(description: 'has the correct endpoint', closure: function () {
    expect(value: $this->request->resolveEndpoint())->toBe(expected: '/user_management/authenticate');
});

it(description: 'has the correct body', closure: function () {
    expect(value: $this->request->body()->all())->toBe(expected: [
        "code"       => $this->code,
        "grant_type" => GrantType::CODE->value
  ]);
});
