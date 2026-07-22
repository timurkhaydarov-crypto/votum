<?php

namespace Database\Factories\Contacts;

use App\Models\Contacts\OperatingHours;
use App\Models\Department;
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
            'from' => $this->faker->time(),
            'to' => $this->faker->time(),
            'time' => $this->faker->time(),
            'department_id' => Department::factory(),
        ];
    }
}
