<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Contracts;

interface Arrayable
{
    public function array(): array;

    public function json(): string|false;
}
