<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use App\Models\Product\ProductCompatibility;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCompatibilityController extends Controller
{
    /**
     * Return compatible products and products available
     * for adding.
     *
     * Supports search by:
     * - ID
     * - article
     * - RU name
     * - EN name
     */
    public function index(
        Request $request,
        Product $product,
    ): JsonResponse {
        $search = trim(
            (string) $request->query('search', '')
        );

        /*
         * Current compatible product IDs.
         */
        $compatibleProductIds =
            ProductCompatibility::query()
                ->where(
                    'product_id',
                    $product->id,
                )
                ->pluck(
                    'compatible_product_id',
                )
                ->map(
                    fn ($id) => (int) $id,
                )
                ->values();

        /*
         * Products available for selection.
         *
         * The current product itself is excluded.
         */
        $products = Product::query()
            ->whereKeyNot(
                $product->id,
            )
            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(
                        function ($query) use ($search) {
                            /*
                             * ID
                             */
                            if (ctype_digit($search)) {
                                $query->orWhere(
                                    'id',
                                    (int) $search,
                                );
                            }

                            /*
                             * Article
                             */
                            $query->orWhere(
                                'article',
                                'ILIKE',
                                "%{$search}%",
                            );

                            /*
                             * RU / EN product name.
                             */
                            $query->orWhereRaw(
                                "name->>'ru' ILIKE ?",
                                ["%{$search}%"],
                            );

                            $query->orWhereRaw(
                                "name->>'en' ILIKE ?",
                                ["%{$search}%"],
                            );
                        },
                    );
                },
            )
            ->orderBy('id')
            ->get([
                'id',
                'article',
                'name',
            ]);

        return response()->json([
            'products' => $products
                ->map(
                    fn (Product $item) => $this->serializeProduct(
                        $item,
                        $compatibleProductIds,
                    ),
                )
                ->values()
                ->all(),

            'compatible_product_ids' =>
                $compatibleProductIds->all(),
        ]);
    }

    /**
     * Attach compatible product.
     */
    public function attach(
        Product $product,
        Product $compatibleProduct,
    ): JsonResponse {
        /*
         * A product cannot be compatible with itself.
         */
        if (
            $product->id ===
            $compatibleProduct->id
        ) {
            return response()->json([
                'message' =>
                    'A product cannot be compatible with itself.',
            ], 422);
        }

        /*
         * Avoid duplicate relationships.
         */
        ProductCompatibility::query()->firstOrCreate([
            'product_id' =>
                $product->id,

            'compatible_product_id' =>
                $compatibleProduct->id,
        ]);

        return response()->json([
            'message' =>
                'Compatible product attached successfully.',

            'product' =>
                $this->serializeProduct(
                    $compatibleProduct,
                    collect([
                        $compatibleProduct->id,
                    ]),
                ),
        ]);
    }

    /**
     * Detach compatible product.
     */
    public function detach(
        Product $product,
        Product $compatibleProduct,
    ): JsonResponse {
        ProductCompatibility::query()
            ->where(
                'product_id',
                $product->id,
            )
            ->where(
                'compatible_product_id',
                $compatibleProduct->id,
            )
            ->delete();

        return response()->json([
            'message' =>
                'Compatible product detached successfully.',
        ]);
    }

    /**
     * Serialize product for compatibility UI.
     */
    protected function serializeProduct(
        Product $product,
        $compatibleProductIds,
    ): array {
        return [
            'id' => $product->id,

            'article' => $product->article,

            'name' => $product->name,

            'attached' =>
                $compatibleProductIds->contains(
                    (int) $product->id,
                ),
        ];
    }
}