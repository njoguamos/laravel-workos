<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Contracts;

interface Fillable
{
    public function getFilledData(): array;
}
