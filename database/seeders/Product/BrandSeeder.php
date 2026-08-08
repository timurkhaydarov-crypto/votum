<?php

namespace Database\Seeders\Product;

use Illuminate\Database\Seeder;
use App\Models\Product\Brand;
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
            Brand::factory()->create([
                'brand' => $item['brand'],
                'logo' => 'brand_technovotum_logo',
                'description' => $item['description'],
            ]);
        }
    }
}
