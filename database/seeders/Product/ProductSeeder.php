<?php

namespace Database\Seeders\Product;

use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\Group;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandIds = Brand::query()->orderBy('id')->pluck('id')->values();

        $products = array_merge(
            require __DIR__ . '/data/industrial_ndt.php',
            require __DIR__ . '/data/flaw_detectors.php',
            require __DIR__ . '/data/scanning_devices.php',
            require __DIR__ . '/data/transducers.php',
            require __DIR__ . '/data/reference_standards.php',
        );

        foreach ($products as $index => $item) {
            $categoryId = Category::query()
                ->where('slug', $item['category'])
                ->value('id');

            if (!$categoryId) {
                throw new \RuntimeException(sprintf('Category slug not found: %s', $item['category']));
            }

            $groupId = Group::query()
                ->where('slug', $item['group'])
                ->value('id');

            if (!$groupId) {
                throw new \RuntimeException(sprintf('Group slug not found: %s', $item['group']));
            }

            $brandId = $brandIds->get($index) ?? $brandIds->first() ?? 1;

            $product = Product::query()->create([
                'article' => $item['article'],
                'name' => $item['name'],
                'short_description' => $item['short_description'],
                'full_description' => $item['full_description'],
                'category_id' => $categoryId,
                'group_id' => $groupId,
                'brand_id' => $brandId,
                'unit' => $item['unit'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'status' => $item['status'],
                'note' => $item['note'],
                'image_url' => $item['image_url'],
                'video_url' => $item['video_url'],
            ]);

            $groupSlugs = array_values(array_unique(array_filter([
                $item['group'] ?? null,
                ...($item['groups'] ?? []),
            ])));

            if ($groupSlugs) {
                $groupIds = Group::query()
                    ->whereIn('slug', $groupSlugs)
                    ->pluck('id')
                    ->toArray();

                if ($groupIds) {
                    $product->groups()->sync($groupIds);
                }
            }
        }
    }
}
