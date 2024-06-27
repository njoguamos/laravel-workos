<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use NjoguAmos\LaravelWorkOS\Services\DateParser;

it(description: 'can parse WorkOS timestamps to UTC timezone', closure: function () {
    $dateParser = app(abstract: DateParser::class);

    $parsedDate = $dateParser->parse(timestamp: '2024-06-25T19:07:33.155Z');

    $expectedDate = CarbonImmutable::parse(time: '2024-06-25T19:07:33.155Z')->setTimezone('UTC');

    expect(value: $parsedDate->tzName)->toBe(expected: 'UTC')
        ->and(value: $parsedDate->equalTo($expectedDate))->toBeTrue();
});

it(description: 'can parse WorkOS dates to app timezone', closure: function () {
    config()->set('app.timezone', 'Africa/Nairobi');
    config()->set('workos.convert_timezone', true);

    $dateParser = app(abstract: DateParser::class);

    $parsedDate = $dateParser->parse(timestamp: '2024-06-25T19:07:33.155Z');

    $expectedDate = CarbonImmutable::parse(time: '2024-06-25T19:07:33.155Z')->setTimezone('Africa/Nairobi');

    expect(value: $parsedDate->tzName)->toBe(expected: 'Africa/Nairobi')
        ->and(value: $parsedDate->equalTo($expectedDate))->toBeTrue();
});
