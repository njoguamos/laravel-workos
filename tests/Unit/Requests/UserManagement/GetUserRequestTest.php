<?php

declare(strict_types=1);


use NjoguAmos\LaravelWorkos\Requests\UserManagement\GetUserRequest;
use Saloon\Enums\Method;

it(description: 'has the correct method', closure: function () {
    $request = new GetUserRequest(
        id: 'user_01E4ZCR3C56J083X43JQXF3JK5'
    );

    expect(value: $request->getMethod())->toBe(expected: Method::GET);
});

it(description: 'has the correct endpoint', closure: function () {
    $id = 'user_01E4ZCR3C56J083X43JQXF3JK5';

    $request = new GetUserRequest(id: $id);

    expect(value: $request->resolveEndpoint())->toBe(expected: "/user_management/users/$id");
});
