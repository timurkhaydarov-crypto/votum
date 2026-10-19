<?php

namespace Database\Seeders\Product;

use App\Models\Product\Product;
use Illuminate\Database\Seeder;

class ProductAppImageSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::query()
            ->where('article', 'TOMOGRAPHIC-5M')
            ->firstOrFail();

        $applications = require __DIR__.'/data/product_apps.php';

        foreach ($applications as $application) {
            $productApp = $product->productApps()
                ->where('version', $application['version'])
                ->firstOrFail();

            foreach ($application['images'] as $sortOrder => $imagePath) {
                $productApp->images()->updateOrCreate(
                    ['image_url' => $imagePath],
                    ['sort_order' => $sortOrder]
                );
            }
        }
    }
}
