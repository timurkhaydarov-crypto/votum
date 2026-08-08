<?php

namespace Database\Factories\Product;

use App\Models\Product\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => [
                'ru' => $this->faker->words(2, true),
                'en' => $this->faker->words(2, true),
            ],
            'image_url' => $this->faker->imageUrl(),
            'description' => [
                'ru' => $this->faker->paragraph(),
                'en' => $this->faker->paragraph(),
            ],
        ];
    }
}
