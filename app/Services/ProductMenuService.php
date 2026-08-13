<?php

namespace App\Services;

use App\Models\Product\Category;
use Illuminate\Support\Str;

class ProductMenuService
{
    public function buildMenu(?string $locale = 'ru'): array
    {
        $locale = in_array($locale, ['ru', 'en'], true) ? $locale : 'ru';

        $categories = Category::with(['products.groups'])->orderBy('id')->get();

        return $categories
            ->map(function (Category $category) use ($locale) {
                $groups = $category->products
                    ->flatMap(fn ($product) => $product->groups)
                    ->unique('id')
                    ->values()
                    ->map(function ($group) use ($category, $locale) {
                        $groupProducts = $category->products
                            ->filter(fn ($product) => $product->groups->contains('id', $group->id))
                            ->map(function ($product) use ($category, $group, $locale) {
                                $productId = $product->article
                                    ? Str::slug($product->article)
                                    : (string) $product->id;

                                $title = $this->localized($product->name, $locale)
                                    ?? $product->article
                                    ?? (string) $product->id;

                                $description = $this->localized($product->short_description, $locale)
                                    ?? $this->localized($product->full_description, $locale)
                                    ?? null;

                                return [
                                    'id' => $productId,
                                    'title' => $title,
                                    'href' => '/products/' . $productId,
                                    'image_url' => $product->image_url,
                                    'description' => $description,
                                ];
                            })
                            ->values()
                            ->all();

                        $productIds = array_map(fn ($product) => $product['id'], $groupProducts);

                        return [
                            'id' => $group->slug,
                            'title' => $this->localized($group->group, $locale) ?? $group->slug,
                            'href' => '/products/' . $category->slug . '/' . $group->slug,
                            'icon' => 'bi-grid',
                            'productIds' => $productIds,
                            'products' => $groupProducts,
                        ];
                    })->all();

                return [
                    'id' => $category->slug,
                    'title' => $this->localized($category->category, $locale) ?? $category->slug,
                    'shortTitle' => $this->localized($category->category, $locale) ?? $category->slug,
                    'icon' => 'bi-grid',
                    'href' => '/products/' . $category->slug,
                    'groups' => $groups,
                ];
            })->values()->all();
    }

    protected function localized(?array $value, string $locale): ?string
    {
        if (!is_array($value)) {
            return null;
        }

        return $value[$locale]
            ?? $value['ru']
            ?? $value['en']
            ?? null;
    }
}
