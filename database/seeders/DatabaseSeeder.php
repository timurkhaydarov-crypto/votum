<?php

namespace Database\Seeders;

use Database\Seeders\Contacts\EmailSeeder;
use Database\Seeders\Contacts\OperatingHoursSeeder;
use Database\Seeders\Contacts\PhoneSeeder;
use Database\Seeders\Contacts\SocialMediaSeeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory(5)->create();

        $this->call([
            DepartmentSeeder::class,
            PhoneSeeder::class,
            EmailSeeder::class,
            SocialMediaSeeder::class,
            OperatingHoursSeeder::class,
        ]);
    }
}
