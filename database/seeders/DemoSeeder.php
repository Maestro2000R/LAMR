<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;
use App\Models\Site;
use App\Models\Assignment;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run()
    {
        // Create sites
        $sites = collect([
            ['name' => 'Site Alpha', 'address' => '1 Rue Alpha', 'city' => 'Paris'],
            ['name' => 'Site Beta', 'address' => '2 Rue Beta', 'city' => 'Lyon'],
        ])->map(function($s){ return Site::create($s); });

        // Create agents
        $agents = collect([
            ['name' => 'Alice Dupont', 'email' => 'alice@example.test', 'phone' => '0600000001', 'status' => 'active'],
            ['name' => 'Bob Martin', 'email' => 'bob@example.test', 'phone' => '0600000002', 'status' => 'inactive'],
        ])->map(function($a){ return Agent::create($a); });

        // Assignments
        Assignment::create([
            'agent_id' => $agents->first()->id,
            'site_id' => $sites->first()->id,
            'starts_at' => now()->subDays(10),
            'ends_at' => now()->addDays(20),
            'role' => 'Surveillance',
        ]);

        Assignment::create([
            'agent_id' => $agents->last()->id,
            'site_id' => $sites->last()->id,
            'starts_at' => now(),
            'role' => 'Maintenance',
        ]);
    }
}
