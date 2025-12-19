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

        return $cart ?? [];
    }

    public function add($product_id)
    {
        $result = $this->repo->addProduct($product_id);
        $product = $result['product'];
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

        return CartItem::create([
            'cart_id' => $result['cart']->id,
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
