<?php

namespace Database\Seeders\Product;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product\ProductGallery;
use App\Models\Product\Product;

class ProductGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gallery = require __DIR__.'/data/gallery.php';

       foreach ($gallery as $img) {
            $productImageUrl = preg_replace(
                '/_\d+$/',
                '',
                $img['image_url']
            );

            $product = Product::query()
                ->where('image_url', $productImageUrl)
                ->first();

            if (!$product) {
                continue;
            }

            ProductGallery::query()->create([
                'product_id' => $product->id,
                'title' => $img['title'],
                'description' => $img['description'],
                'image_url' => $img['image_url'],
            ]);
        }

    }
}
