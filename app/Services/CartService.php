<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Models\CartItem;

class CartService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CartRepository $repo
    ) {}

    public function index()
    {
        $cart = $this->repo->index();
        // dd(count($cart->items));

        return $cart ?? [];
    }

    public function add($product_id)
    {
        $result = $this->repo->addProduct($product_id);
        $product = $result['product'];
        $cart = $result['cart'];


        if ($product->stock === 0) {
            throw new \Exception(
                'Insufficient stock. Available : ' . $product->stock
            );
        }

        if ($result['type'] === 'exist') {
            $cartItem = $result['cartItem'];


            if ($cartItem->qty >= $product->stock) {
                throw new \Exception(
                    'Insufficient stock. Available : ' . $product->stock
                );
            }

            $cartItem->increment('qty');
            return $cartItem;
        }

        if (count($cart->items) >= 10) {
            throw new \Exception(
                'You already have 10 items in your cart !!'
            );
        }

        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 1,
            'price' => $product->price
        ]);
    }

    public function update($request, $product_id)
    {
        $result = $this->repo->updateQuantity($product_id);

        $product = $result['product'];
        $cartItem = $result['cartItem'];

        if (!$cartItem) {
            throw new \Exception('Product not found in cart');
        }


        if ($request->qty > $product->stock) {
            throw new \Exception(
                'Insufficient stock. Available : ' . $product->stock
            );
        }

        $cartItem->update([
            'qty' => $request->qty
        ]);

        return $cartItem;
    }

    public function remove($product_id)
    {

        $cartItem = $this->repo->removeItem($product_id);

        if (!$cartItem) {
            throw new \Exception(
                'Product not found in cart'
            );
        }

        return $cartItem->delete();
    }
}
