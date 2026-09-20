<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        $startsAt = $this->faker->dateTimeBetween('-2 months', '+1 week');
        $hasEnded = $this->faker->boolean(40);

        return [
            'agent_id' => Agent::factory(),
            'site_id' => Site::factory(),
            'role' => $this->faker->randomElement(['Surveillance', 'Maintenance', 'Accueil', 'Sécurité', 'Nettoyage']),
            'starts_at' => $startsAt,
            'ends_at' => $hasEnded ? $this->faker->dateTimeBetween($startsAt, '+2 months') : null,
        ];
    }
}
