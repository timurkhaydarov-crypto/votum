<?php

namespace Database\Seeders\Product;

use App\Models\Product\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'brand' => ['ru' => 'Техновотум', 'en' => 'Technovotum'],
                'description' => [
                    'ru' => 'Российский производитель оборудования неразрушающего контроля',
                    'en' => 'Russian manufacturer of non-destructive testing equipment',
                ],
            ],
        ];

        foreach ($brands as $item) {
            Brand::query()->create([
                'brand' => $item['brand'],
                'logo' => 'brand_technovotum_logo',
                'description' => $item['description'],
            ]);
        }
    }
}
