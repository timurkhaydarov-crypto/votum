<?php

namespace Database\Seeders\Contacts;

use App\Models\Contacts\Email;
use App\Models\Department;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::query()->get()->each(function ($department) {
            Email::factory()->create(['department_id' => $department->id]);
        });
    }
}
