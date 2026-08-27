<?php

namespace Database\Factories\Product;

use App\Models\Product\ProductSpecification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductSpecification>
 */
class ProductSpecificationFactory extends Factory
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
            'name' => [
                'ru' => fake()->sentence(3),
                'en' => fake()->sentence(3),
            ],
            'value' => [
                'ru' => fake()->sentence(3),
                'en' => fake()->sentence(3),
            ],
        ];
    }
}
