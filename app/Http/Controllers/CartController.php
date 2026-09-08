<?php

namespace App\Http\Controllers;

use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get current cart.
     */
    public function index(Request $request): JsonResponse
    {
        $cart = $this->getCart($request);

        $cart->load([
            'items.product.category',
        ]);

        return response()->json(
            $this->formatCart($cart)
        );
    }

    /**
     * Add product to cart.
     *
     * If the product already exists,
     * its quantity is increased.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $cart = $this->getCart($request);

        $product = Product::query()
            ->with('category')
            ->findOrFail($validated['product_id']);

        $item = CartItem::query()->firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $item->quantity = ($item->exists ? $item->quantity : 0)
            + $validated['quantity'];

        $item->save();

        $item->load('product.category');

        return response()->json([
            'message' => 'Product added to cart.',
            'item' => $this->formatCartItem($item),
            'count' => $this->getCartCount($cart),
        ], $item->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Update cart item quantity.
     *
     * quantity = 0 removes the item.
     */
    public function update(
        Request $request,
        Product $product,
    ): JsonResponse {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $cart = $this->getCart($request);

        $item = CartItem::query()
            ->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if (! $item) {
            return response()->json([
                'message' => 'Cart item not found.',
            ], 404);
        }

        if ($validated['quantity'] === 0) {
            $item->delete();

            return response()->json([
                'message' => 'Cart item removed.',
                'count' => $this->getCartCount($cart),
            ]);
        }

        $item->update([
            'quantity' => $validated['quantity'],
        ]);

        $item->load('product.category');

        return response()->json([
            'message' => 'Cart item updated.',
            'item' => $this->formatCartItem($item),
            'count' => $this->getCartCount($cart),
        ]);
    }

    /**
     * Remove product from cart.
     */
    public function destroy(
        Request $request,
        Product $product,
    ): JsonResponse {
        $cart = $this->getCart($request);

        $deleted = CartItem::query()
            ->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->delete();

        if (! $deleted) {
            return response()->json([
                'message' => 'Cart item not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Product removed from cart.',
            'count' => $this->getCartCount($cart),
        ]);
    }

    /**
     * Clear cart.
     */
    public function clear(Request $request): JsonResponse
    {
        $cart = $this->getCart($request);

        $cart->items()->delete();

        return response()->json([
            'message' => 'Cart cleared.',
            'count' => 0,
        ]);
    }

    /**
     * Get or create current cart.
     *
     * The cart is identified by the current session ID.
     * The session cart_id is kept as a convenience reference.
     */
    private function getCart(Request $request): Cart
    {
        $sessionId = $request->session()->getId();

        $cart = Cart::query()->firstOrCreate([
            'session_id' => $sessionId,
        ]);

        $request->session()->put(
            'cart_id',
            $cart->id
        );

        return $cart;
    }

    /**
     * Format cart response.
     */
    private function formatCart(Cart $cart): array
    {
        return [
            'id' => $cart->id,

            'items' => $cart->items
                ->map(
                    fn (CartItem $item) =>
                        $this->formatCartItem($item)
                )
                ->values()
                ->all(),

            'count' => $this->getCartCount($cart),
        ];
    }

    /**
     * Format cart item.
     */
    private function formatCartItem(CartItem $item): array
    {
        $product = $item->product;

        return [
            'id' => $item->id,
            'cart_id' => $item->cart_id,
            'product_id' => $item->product_id,
            'quantity' => (int) $item->quantity,

            'product' => [
                'id' => $product->id,
                'article' => $product->article,
                'name' => $product->name,

                'image_url' => $this->getProductImageUrl(
                    $product
                ),

                'unit' => $product->unit,
                'available_quantity' => $product->quantity,
            ],
        ];
    }

    /**
     * Build product image URL.
     */
    private function getProductImageUrl(Product $product): ?string
    {
        $image = $product->getRawOriginal('image_url');

        $categorySlug = $product->category?->slug;

        if (! $image || ! $categorySlug) {
            return null;
        }

        return "/image/product/{$categorySlug}/{$image}.webp";
    }

    /**
     * Get total quantity in cart.
     */
    private function getCartCount(Cart $cart): int
    {
        return (int) $cart->items()->sum('quantity');
    }
}