<?php

namespace Database\Seeders;

use Database\Seeders\Contacts\EmailSeeder;
use Database\Seeders\Contacts\OperatingHoursSeeder;
use Database\Seeders\Contacts\PhoneSeeder;
use Database\Seeders\Contacts\SocialMediaSeeder;
use Database\Seeders\Product\BrandSeeder;
use Database\Seeders\Product\CategorySeeder;
use Database\Seeders\Product\CertificateSeeder;
use Database\Seeders\Product\FeaturesGallerySeeder;
use Database\Seeders\Product\GroupSeeder;
use Database\Seeders\Product\MethodSeeder;
use Database\Seeders\Product\ProductCompatibilitySeeder;
use Database\Seeders\Product\ProductFeaturesSeeder;
use Database\Seeders\Product\ProductGallerySeeder;
use Database\Seeders\Product\ProductSeeder;
use Database\Seeders\Product\SectorSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::transaction(function () {
            $this->call([
                DepartmentSeeder::class,
                PhoneSeeder::class,
                EmailSeeder::class,
                SocialMediaSeeder::class,
                OperatingHoursSeeder::class,
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
                DealerSeeder::class,
            ]);
        });
    }
}
