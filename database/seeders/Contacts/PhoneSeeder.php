<?php

namespace Database\Seeders\Contacts;

use App\Models\Contacts\Phone;
use App\Models\Department;
use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phones = [
            1 => '+7(499)995-00-61',
            2 => '+7(499)995-00-62',
            3 => '+7(499)995-24-75',
        ];
        $departmentId = 1;
        foreach ($phones as $departmentId => $phone) {
            Phone::factory()->create([
                'department_id' => $departmentId,
                'phone' => $phone,
            ]);
        }

    }
}
