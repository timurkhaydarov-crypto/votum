<?php

namespace Database\Factories\Contacts;

use App\Models\Contacts\Email;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

/**
 * @extends Factory<Email>
 */
class EmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'department_id' => Department::factory(),
        ];
    }
}
