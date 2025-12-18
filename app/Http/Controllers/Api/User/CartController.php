<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{

    // add item to card
    public function add($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found !!'
            ], 200);
        }

        $cart = session()->get('cart', []); // get cart from session, or empty array

        if (isset($cart[$id])) {
            $cart[$id]['qty']++; // if product exists, increment quantity
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "qty" => 1
            ];
        }

        session()->put('cart', $cart); // save back to session
        return response()->json([
            'status' => 'success',
            'cart' => $cart
        ]);
    }

    // update card 
    public function update($id)
    {
        // 
    }

    // remove item from card
    public function remove($id)
    {
        //
    }

    // check cart
    public function index()
    {
        $cart = session()->get('cart', []);

        return response()->json([
            'status' => 'success',
            'cart' => $cart
        ], 200);
    }
}
