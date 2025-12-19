<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Product;
// use App\Models\Cart;
// use App\Models\CartItem;
// use Illuminate\Support\Facades\Auth;
use App\Services\CartService;


class CartController extends Controller
{

    // check cart
    public function index(CartService $service)
    {
        return response()->json([
            'status' => 'success',
            'cart' => $service->index(),
        ]);
    }
    // add item to cart
    public function add(CartService $service, $id)
    {

        try {
            $item = $service->add($id);

            return response()->json([
                'status' => 'success',
                'data' => $item
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // update item in cart
    public function update(CartService $service, Request $request, $id)
    {
        return response()->json([
            'status' => 'success',
            'cart item' => $service->update($request, $id)
        ], 200);
    }

    // remove item from cart
    public function remove(CartService $service, $id)
    {

        $service->remove($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Item deleted successful'
        ]);
    }
}
