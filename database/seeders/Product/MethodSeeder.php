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
        Product::query()
            ->orderBy('id')
            ->limit(5)
            ->pluck('id')
            ->each(function ($productId) {
                $methods = [
                    'ut_method' => (bool) random_int(0, 1),
                    'et_method' => (bool) random_int(0, 1),
                    'mia_method' => (bool) random_int(0, 1),
                    'iet_method' => (bool) random_int(0, 1),
                    'mt_method' => (bool) random_int(0, 1),
                    'vt_method' => (bool) random_int(0, 1),
                ];

                if (!in_array(true, $methods, true)) {
                    $randomMethod = array_rand($methods);
                    $methods[$randomMethod] = true;
                }

                Method::query()->create([
                    'product_id' => $productId,
                    ...$methods,
                ]);
            });
    }
}
