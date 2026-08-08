<?php

namespace Database\Factories\Product;

use App\Models\Product\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sector>
 */
class SectorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 100),
            'railway' => $this->faker->boolean(),
            'aerospace' => $this->faker->boolean(),
            'oil' => $this->faker->boolean(),
        ];
    }
}
