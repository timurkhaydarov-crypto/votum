<?php

namespace Database\Seeders;

use Database\Seeders\Contacts\EmailSeeder;
use Database\Seeders\Contacts\OperatingHoursSeeder;
use Database\Seeders\Contacts\PhoneSeeder;
use Database\Seeders\Contacts\SocialMediaSeeder;
use Database\Seeders\Product\BrandSeeder;
use Database\Seeders\Product\CategorySeeder;
use Database\Seeders\Product\GroupSeeder;
use Database\Seeders\Product\MethodSeeder;
use Database\Seeders\Product\ProductSeeder;
use Database\Seeders\Product\SectorSeeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

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

        if (
            Schema::hasTable('categories')
            && Schema::hasTable('groups')
            && Schema::hasTable('brands')
            && Schema::hasTable('products')
            && Schema::hasTable('sectors')
            && Schema::hasTable('methods')
        ) {
            $this->call([
                CategorySeeder::class,
                GroupSeeder::class,
                BrandSeeder::class,
                ProductSeeder::class,
                SectorSeeder::class,
                MethodSeeder::class,
            ]);
        }
    }
}
