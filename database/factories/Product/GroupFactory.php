<?php

namespace Database\Factories\Product;

use App\Models\Product\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Product\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group' => [
                'ru' => $this->faker->words(2, true),
                'en' => $this->faker->words(2, true),
            ],
            'slug' => $this->faker->slug(),
            'image_url' => $this->faker->imageUrl(),
            'description' => [
                'ru' => $this->faker->paragraph(),
                'en' => $this->faker->paragraph(),
            ],
        ];
    }
}
