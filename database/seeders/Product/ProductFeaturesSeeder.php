<?php

namespace Database\Seeders\Product;

use App\Models\Product\ProductFeatures;
use App\Models\Product\Product;
use Illuminate\Database\Seeder;

class ProductFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $functionalities = require __DIR__ . '/data/features.php';

        foreach ($functionalities as $item) {
            $product = Product::query()
                ->where('article', $item['article'])
                ->firstOrFail();

            ProductFeatures::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                ],
                [
                    'features' => $item['features'],
                ]
            );
        }
    }
}