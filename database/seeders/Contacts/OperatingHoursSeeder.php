<?php

namespace Database\Seeders\Contacts;

use App\Models\Contacts\OperatingHours;
use App\Models\Department;
use Illuminate\Database\Seeder;

class OperatingHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentId = Department::query()->orderBy('id')->value('id');

        if (! $departmentId) {
            throw new \RuntimeException('Operating hours require a seeded department.');
        }

        OperatingHours::query()->create([
            'from' => 'monday',
            'to' => 'friday',
            'time' => '09:00 - 18:00',
            'department_id' => $departmentId,
        ]);
    }
}
