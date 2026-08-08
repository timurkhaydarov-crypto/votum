<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product\Category;
use App\Models\Product\Brand;
use App\Models\Product\Group;
/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'article' => $this->faker->unique()->word(),
            'name' => [
                'ru' => $this->faker->words(2, true),
                'en' => $this->faker->words(2, true),
            ],
            'short_description' => [
                'ru' => $this->faker->sentence(),
                'en' => $this->faker->sentence(),
            ],
            'full_description' => [
                'ru' => $this->faker->paragraph(),
                'en' => $this->faker->paragraph(),
            ],
            'category_id' => Category::factory(),
            'group_id' => Group::factory(),
            'brand_id' => Brand::factory(),
            'unit' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->boolean(),
            'note' => [
                'ru' => $this->faker->optional()->sentence(),
                'en' => $this->faker->optional()->sentence(),
            ],
            'image_url' => $this->faker->optional()->imageUrl(),
            'video_url' => $this->faker->optional()->url(),
        ];
    }
}
