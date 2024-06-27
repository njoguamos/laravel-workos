<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Contracts;

interface Fillable
{
    public function getFilledData(array $except = []): array;
}
