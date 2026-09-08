<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Product\Product;
// use Illuminate\Support\Facades\DB;

class CartService
{

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
     * Add product to cart.
     *
     * If product already exists in cart,
     * increase its quantity.
     */
    public function add(Product $product, int $quantity = 1): CartItem
    {
        if ($quantity < 1) {
            $quantity = 1;
        }

        $cart = $this->getCart();

        $item = $cart->items()->where(
            'product_id',
            $product->id
        )->first();

        if ($item) {
            $item->increment('quantity', $quantity);

            return $item->refresh();
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }

    /**
     * Update product quantity.
     */
    public function updateQuantity(
        Product $product,
        int $quantity
    ): ?CartItem {
        $cart = $this->getCart();

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if (!$item) {
            return null;
        }

        if ($quantity < 1) {
            $item->delete();

            return null;
        }

        $item->update([
            'quantity' => $quantity,
        ]);

        return $item->refresh();
    }

    /**
     * Remove product from cart.
     */
    public function remove(Product $product): bool
    {
        $cart = $this->getCart();

        return $cart->items()
            ->where('product_id', $product->id)
            ->delete() > 0;
    }

    /**
     * Clear cart.
     */
    public function clear(): void
    {
        $cart = $this->getCart();

        $cart->items()->delete();
    }

    /**
     * Get total quantity of products.
     */
    public function count(): int
    {
        return $this->getCart()
            ->items()
            ->sum('quantity');
    }

    /**
     * Check whether product exists in cart.
     */
    public function has(Product $product): bool
    {
        return $this->getCart()
            ->items()
            ->where('product_id', $product->id)
            ->exists();
    }

    /**
     * Get cart with products.
     */
    public function getCartWithProducts(): Cart
    {
        return $this->getCart()
            ->load('items.product');
    }
}