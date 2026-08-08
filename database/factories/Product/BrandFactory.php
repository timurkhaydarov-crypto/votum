<?php

namespace Database\Factories\Product;

use App\Models\Product\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => [
                'ru' => $this->faker->company(),
                'en' => $this->faker->company(),
            ],
            'logo' => $this->faker->imageUrl(),
            'description' => [
                'ru' => $this->faker->paragraph(),
                'en' => $this->faker->paragraph(),
            ],
        ];
    }
}
