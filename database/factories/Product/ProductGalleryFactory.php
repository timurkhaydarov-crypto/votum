<?php

namespace Database\Factories\Product;

use App\Models\Product\ProductGallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductGallery>
 */
class ProductGalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => null,
            'title' => [
                'ru' => fake()->sentence(3),
                'en' => fake()->sentence(3),
            ],
            'image_url' => fake()->slug(2),
            'description' => [
                'ru' => fake()->sentence(),
                'en' => fake()->sentence(),
            ],
        ];
    }
}
