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
        $departments = Department::query()->orderBy('id')->get();
        $phoneNumbers = array_values($phones);

        if ($departments->count() < count($phoneNumbers)) {
            throw new \RuntimeException('Each seeded phone number requires a department.');
        }

        foreach ($phoneNumbers as $index => $phone) {
            Phone::query()->create([
                'department_id' => $departments[$index]->id,
                'phone' => $phone,
            ]);
        }

    }
}
