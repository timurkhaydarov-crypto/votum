<?php

namespace Database\Seeders\Contacts;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Contacts\Phone;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::query()->get()->each(function ($department) {
            Phone::factory(2)->create(['department_id' => $department->id]);
        });
    }
}
