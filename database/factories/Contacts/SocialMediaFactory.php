<?php

namespace Database\Factories\Contacts;

use App\Models\Contacts\SocialMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialMedia>
 */
class SocialMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'platform' => $this->faker->word(),
            'url' => $this->faker->url(),
            'icon' => $this->faker->word(),
        ];
    }
}
