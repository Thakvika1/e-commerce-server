<?php

namespace App\Http\Controllers\Api\User\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class RemoveItemController extends Controller
{
    // remove item from cart
    public function __invoke(CartService $service, $id)
    {

        $service->remove($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Item remove from successful'
        ]);
    }
}
