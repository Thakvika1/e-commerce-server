<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class CheckoutRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function checkout()
    {
        $cart = Cart::with('items')
            ->where('user_id', Auth::user()->id)
            ->first();

        return $cart;
    }

    public function orderList($perPage)
    {
        $order = Order::with('orderItems')->paginate($perPage);

        return $order;
    }

    public function updateOrder($id, array $data)
    {
        $order = Order::findOrFail($id);

        $order->update($data);
        return $order;
    }
}
