<?php

namespace Database\Factories\Product;

use App\Models\Product\Method;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Method>
 */
class MethodFactory extends Factory
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
            'ut_method' => $this->faker->boolean(),
            'et_method' => $this->faker->boolean(),
            'mia_method' => $this->faker->boolean(),
            'iet_method' => $this->faker->boolean(),
            'mt_method' => $this->faker->boolean(),
            'vt_method' => $this->faker->boolean(),
        ];
    }
}
