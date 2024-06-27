<?php

declare(strict_types=1);


use Illuminate\Support\Str;
use NjoguAmos\LaravelWorkOS\Requests\GetUserRequest;
use Saloon\Enums\Method;

beforeEach(function () {
    $this->user_id = "user_".Str::ulid()->toString();

    $this->request = new GetUserRequest(id: $this->user_id);
});

it(description: 'has the correct method', closure: function () {
    expect(value: $this->request->getMethod())
        ->toBe(expected: Method::GET);
});

it(description: 'has the correct endpoint', closure: function () {
    expect(value: $this->request->resolveEndpoint())
        ->toBe(expected: "/user_management/users/$this->user_id");
});
