<?php

namespace Database\Factories\Contacts;

use App\Models\Contacts\OperatingHours;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OperatingHours>
 */
class OperatingHoursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'operating_hours' => $this->faker->sentence(),
        ];
    }
}
