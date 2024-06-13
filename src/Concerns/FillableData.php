<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Concerns;

use BackedEnum;

trait FillableData
{
    public function getFilledData(): array
    {
        return collect(get_object_vars($this))
            ->filter(fn ($value) => !is_null($value) && $value !== '')
            ->map(callback: fn ($value) => $value instanceof BackedEnum ? $value->value : $value)
            ->toArray();
    }
}
