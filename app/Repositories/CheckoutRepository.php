<?php

namespace App\Repositories;

use App\Models\Cart;
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
}
