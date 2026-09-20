<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin LAMR',
            'email' => 'admin@lamr.test',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            DemoSeeder::class,
        ]);
    }
}
