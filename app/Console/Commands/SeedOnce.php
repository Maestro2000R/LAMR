<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SeedOnce extends Command
{
    protected $signature = 'app:seed-once';

    protected $description = 'Seed the database with demo data, but only if it looks empty (safe to run on every deploy).';

    public function handle(): int
    {
        if (User::query()->exists()) {
            $this->info('Database already has data — skipping seed.');

            return self::SUCCESS;
        }

        $this->call('db:seed', ['--force' => true]);

        return self::SUCCESS;
    }
}
