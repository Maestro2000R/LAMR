<?php

namespace Database\Factories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Site>
 */
class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {
        return [
            'name' => 'Site '.$this->faker->unique()->city(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
        ];
    }
}
