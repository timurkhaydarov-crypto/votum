<?php

namespace Database\Seeders\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductSpecification;
use Illuminate\Database\Seeder;

class ProductSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specifications = require __DIR__ . '/data/specifications.php';

        foreach ($specifications as $item) {
            $product = Product::query()
                ->where('article', $item['article'])
                ->first();

            if (!$product) {
                $this->command->warn(
                    "Product not found: {$item['article']}"
                );

                continue;
            }

            $data = $item['specifications'];

            $ruSpecifications = $data['ru'] ?? [];
            $enSpecifications = $data['en'] ?? [];

            // Удаляем старые характеристики товара,
            // чтобы при повторном запуске не создавать дубли.
            ProductSpecification::query()
                ->where('product_id', $product->id)
                ->delete();

            $count = max(
                count($ruSpecifications),
                count($enSpecifications)
            );

            for ($index = 0; $index < $count; $index++) {
                $ru = $ruSpecifications[$index] ?? [];
                $en = $enSpecifications[$index] ?? [];

                ProductSpecification::query()->create([
                    'product_id' => $product->id,

                    'name' => [
                        'ru' => $ru['name'] ?? null,
                        'en' => $en['name'] ?? null,
                    ],

                    'value' => [
                        'ru' => $ru['value'] ?? null,
                        'en' => $en['value'] ?? null,
                    ],
                ]);
            }

            $this->command->info(
                "Specifications seeded: {$item['article']}"
            );
        }
    }
}