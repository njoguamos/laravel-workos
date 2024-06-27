<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Concerns;

use Carbon\CarbonImmutable;

trait HasWorkOSTimestamps
{
    /**
     * Format the given CarbonImmutable instance back to WorkOS timestamp.
     */
    public function format(CarbonImmutable $dateTime): string
    {
        return $dateTime->format(format: 'Y-m-d\TH:i:s.v\Z');
    }
}
