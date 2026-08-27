<?php

namespace Database\Seeders\Product;

use App\Models\Product\Product;
use Illuminate\Database\Seeder;

class ProductCompatibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $compatibilities = require __DIR__.'/data/compatibilities.php';

        foreach ($compatibilities as $article => $compatibleArticles) {
            $product = Product::query()
                ->where('article', $article)
                ->first();

            if (! $product) {
                $this->command->warn(
                    "Product not found: {$article}"
                );

                continue;
            }

            foreach ($compatibleArticles as $compatibleArticle) {
                $compatibleProduct = Product::query()
                    ->where('article', $compatibleArticle)
                    ->first();

                if (! $compatibleProduct) {
                    $this->command->warn(
                        "Compatible product not found: {$compatibleArticle}"
                    );

                    continue;
                }

                if ($product->id === $compatibleProduct->id) {
                    $this->command->warn(
                        "Self compatibility skipped: {$article}"
                    );

                    continue;
                }

                $product->compatibleProducts()->syncWithoutDetaching([
                    $compatibleProduct->id,
                ]);
            }
        }
    }
}