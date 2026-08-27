<?php

namespace Database\Seeders;

use Database\Seeders\Contacts\EmailSeeder;
use Database\Seeders\Contacts\OperatingHoursSeeder;
use Database\Seeders\Contacts\PhoneSeeder;
use Database\Seeders\Contacts\SocialMediaSeeder;
use Database\Seeders\Product\FeaturesGallerySeeder;
use Database\Seeders\Product\BrandSeeder;
use Database\Seeders\Product\CategorySeeder;
use Database\Seeders\Product\GroupSeeder;
use Database\Seeders\Product\MethodSeeder;
use Database\Seeders\Product\ProductSeeder;
use Database\Seeders\Product\SectorSeeder;
use Database\Seeders\Product\CertificateSeeder;
use Database\Seeders\Product\ProductFeaturesSeeder;
use Database\Seeders\Product\ProductGallerySeeder;
use Database\Seeders\Product\ProductCompatibilitySeeder;
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
            && Schema::hasTable('certificates')
            && Schema::hasTable('products')
            && Schema::hasTable('sectors')
            && Schema::hasTable('methods')
            && Schema::hasTable('product_features')
            && Schema::hasTable('product_galleries')
            && Schema::hasTable('features_galleries')
            && Schema::hasTable('product_compatibilities')
        ) {
            $this->call([
                CategorySeeder::class,
                GroupSeeder::class,
                CertificateSeeder::class,
                BrandSeeder::class,
                ProductSeeder::class,
                SectorSeeder::class,
                MethodSeeder::class,
                ProductFeaturesSeeder::class,
                ProductGallerySeeder::class,
                FeaturesGallerySeeder::class,
                ProductCompatibilitySeeder::class,
            ]);
        }
    }
}
