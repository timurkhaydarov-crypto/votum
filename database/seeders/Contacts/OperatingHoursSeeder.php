<?php

namespace Database\Seeders\Contacts;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contacts\OperatingHours;
class OperatingHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OperatingHours::factory()->create(['operating_hours' => 'Пн. - Пт. 9:00 - 18:00']);
    }
}
