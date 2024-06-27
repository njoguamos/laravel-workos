<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Services;

use Carbon\CarbonImmutable;

class DateParser
{
    public const DEFAULT_WORKOS_TIMEZONE = 'UTC';

    protected string $appTimezone;

    public function __construct(
        public readonly bool $convertToAppTimezone
    ) {
        $this->appTimezone = config(key: 'app.timezone');
    }

    public function parse(string $timestamp): CarbonImmutable
    {
        $datetime = CarbonImmutable::parse(time: $timestamp)
            ->setTimezone(self::DEFAULT_WORKOS_TIMEZONE);

        if ($this->convertToAppTimezone) {
            return $datetime->setTimezone($this->appTimezone);
        }

        return $datetime;
    }
}
