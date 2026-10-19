<?php

namespace Database\Seeders\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductApp;
use Illuminate\Database\Seeder;

class ProductAppSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::query()
            ->where('article', 'TOMOGRAPHIC-5M')
            ->firstOrFail();

        $applications = require __DIR__.'/data/product_apps.php';

        foreach ($applications as $application) {
            ProductApp::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                    'version' => $application['version'],
                ],
                [
                    'name' => $application['name'],
                    'image' => $application['image'],
                    'purpose' => $application['purpose'],
                    'short_description' => $application['short_description'],
                    'full_description' => $application['full_description'],
                ]
            );
        }
    }
}
