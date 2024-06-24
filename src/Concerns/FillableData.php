<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Concerns;

use BackedEnum;

trait FillableData
{
    public function getFilledData(array $except = []): array
    {
        return collect(get_object_vars($this))
            ->filter(fn ($value) => !is_null($value) && $value !== '')
            ->filter(fn ($value, $key) => !in_array($key, $except))
            ->map(callback: fn ($value) => $value instanceof BackedEnum ? $value->value : $value)
            ->toArray();
    }
}
