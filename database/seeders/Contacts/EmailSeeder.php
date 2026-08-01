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
    $prefixes = [
        1 => 'info',
        2 => 'sales',
        3 => 'support',
    ];

    Department::query()->get()->each(function ($department) use ($prefixes) {
        Email::factory()->create([
            'department_id' => $department->id,
            'email' => ($prefixes[$department->id] ?? 'info') . '@votum.ru',
        ]);
    });
}
}
