<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Contracts;

interface Transformers
{
    public function array(): array;

    public function json(): string|false;
}
