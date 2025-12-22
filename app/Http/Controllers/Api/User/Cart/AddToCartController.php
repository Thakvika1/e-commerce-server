<?php

namespace App\Http\Controllers\Api\User\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class AddToCartController extends Controller
{
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
}
