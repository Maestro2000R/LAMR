<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Site;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $agents = Agent::factory()
            ->count(20)
            ->state(fn () => ['status' => fake()->randomElement(['active', 'active', 'active', 'inactive'])])
            ->create();

        $sites = Site::factory()->count(10)->create();

        Assignment::factory()
            ->count(30)
            ->state(fn () => [
                'agent_id' => $agents->random()->id,
                'site_id' => $sites->random()->id,
            ])
            ->create();
    }
}
