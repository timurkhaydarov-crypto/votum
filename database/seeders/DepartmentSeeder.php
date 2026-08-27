<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['ru' => 'Приемная', 'en' => 'Reception'],
            // ['ru' => 'Отдел продаж', 'en' => 'Sales department'],
            // ['ru' => 'Техническая поддержка', 'en' => 'Technical support'],
        ];

        foreach ($departments as $department) {
            Department::factory()->create([
                'department_name' => $department,
            ]);
        }
    }
}
