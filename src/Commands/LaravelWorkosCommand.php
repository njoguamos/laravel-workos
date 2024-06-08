<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Commands;

use Illuminate\Console\Command;

class LaravelWorkosCommand extends Command
{
    public $signature = 'laravel-workos';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
