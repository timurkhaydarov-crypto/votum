<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['ru' => 'Приемная', 'en' => 'Reception'],
            ['ru' => 'Отдел продаж', 'en' => 'Sales department'],
            ['ru' => 'Техническая поддержка', 'en' => 'Technical support'],
        ];

        foreach ($departments as $department) {
            Department::query()->create([
                'department_name' => $department,
            ]);
        }
    }
}
