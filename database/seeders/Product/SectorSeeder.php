<?php

namespace Database\Seeders\Product;

use App\Models\Product\Product;
use App\Models\Product\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::query()
            ->orderBy('id')
            ->limit(5)
            ->pluck('id')
            ->each(function ($productId) {
                $sectors = [
                    'railway' => (bool) random_int(0, 1),
                    'aerospace' => (bool) random_int(0, 1),
                    'oil' => (bool) random_int(0, 1),
                ];

                if (!in_array(true, $sectors, true)) {
                    $randomSector = array_rand($sectors);
                    $sectors[$randomSector] = true;
                }

                Sector::query()->create([
                    'product_id' => $productId,
                    ...$sectors,
                ]);
            });
    }
}
