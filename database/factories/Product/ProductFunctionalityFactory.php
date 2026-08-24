<?php

namespace Database\Factories\Product;

use App\Models\Product\ProductFeatures;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductFeatures>
 */
class ProductFeaturesFactory extends Factory
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
            'features' => [
                'ru' => '<p>' . fake()->sentence(8) . '</p>',
                'en' => '<p>' . fake()->sentence(8) . '</p>',
            ],
        ];
    }
}
