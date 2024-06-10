<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Concerns;

trait FillableData
{
    public function filled(): array
    {
        return collect($this->all())
            ->filter(fn ($value) => !is_null($value))
            ->toArray();
    }
}
