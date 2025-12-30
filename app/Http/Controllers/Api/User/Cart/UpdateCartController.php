<?php

namespace App\Http\Controllers\Api\User\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use Exception;

class UpdateCartController extends Controller
{
    // update item in cart
    public function update(CartService $service, Request $request, $id)
    {

        try {
            return response()->json([
                'status' => 'success',
                'cart item' => $service->update($request, $id)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
