<?php

declare(strict_types=1);

arch(description: 'it will not use debugging functions')
    ->expect(value: ['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

test(description: 'connector')
    ->expect(value: 'NjoguAmos\LaravelWorkOS\Connectors\WorkOSConnector')
    ->toBeSaloonConnector()
    ->toUseAlwaysThrowOnErrorsTrait()
    ->toHaveRateLimits();
