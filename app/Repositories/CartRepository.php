<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function index()
    {
        return Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->first();
    }

    public function addProduct($product_id)
    {
        $product = Product::findOrFail($product_id);

        // if cart exist get else create new cart with this user id
        $cart =  Cart::firstOrCreate(['user_id' => Auth::user()->id]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            return [
                'type' => 'exist',
                'cartItem' => $cartItem,
                'product' => $product,
                'cart' => $cart
            ];
        }

        return [
            'type' => 'new',
            'cartItem' => null,
            'product' => $product,
            'cart' => $cart
        ];
    }

    public function updateQuantity($product_id)
    {
        $product = Product::findOrFail($product_id);

        // $cart = Cart::where('user_id', Auth::user()->id)->first();
        $cart =  Cart::firstOrCreate(['user_id' => Auth::user()->id]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        return [
            'cartItem' => $cartItem,
            'product' => $product
        ];
    }

    public function removeItem($product_id)
    {

        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return null;
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product_id)
            ->first();

        return $cartItem;
    }
}
