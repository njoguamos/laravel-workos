<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Contracts;

use Carbon\CarbonImmutable;

interface WorkOSTimestamps
{
    /**
     * Format the given CarbonImmutable instance back to WorkOS timestamp.
     */
    public function format(CarbonImmutable $dateTime): string;
}
