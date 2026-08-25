<?php

namespace Database\Seeders\Product;

use App\Models\Product\FeaturesGallery;
use App\Models\Product\Product;
use App\Models\Product\ProductFeatures;
use Illuminate\Database\Seeder;

class FeaturesGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gallery = require __DIR__.'/data/features/gallery.php';

        foreach ($gallery as $img) {
            $product = Product::query()
                ->where('article', $img['article'])
                ->first();

            if (!$product) {
                continue;
            }

            $features = ProductFeatures::query()
                ->where('product_id', $product->id)
                ->first();

            if (!$features) {
                continue;
            }

            FeaturesGallery::query()->create([
                'features_id' => $features->id,
                'title' => $img['title'],
                'image_url' => $img['image_url'],
            ]);
        }
    }
}