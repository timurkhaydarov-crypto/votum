<?php

namespace Database\Seeders\Product;

use App\Models\Product\Method;
use App\Models\Product\Product;
use Illuminate\Database\Seeder;

class MethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = require __DIR__.'/data/methods.php';

        foreach ($methods as $item) {
            $product = Product::query()
                ->where('article', $item['article'])
                ->first();

            if (!$product) {
                $this->command->warn(
                    "Product not found: {$item['article']}"
                );

                continue;
            }

            Method::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                ],
                [
                    'ut_method' => $item['ut_method'],
                    'et_method' => $item['et_method'],
                    'mia_method' => $item['mia_method'],
                    'iet_method' => $item['iet_method'],
                    'mt_method' => $item['mt_method'],
                    'vt_method' => $item['vt_method'],
                ]
            );
        }
    }
}