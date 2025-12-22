<?php

namespace App\Http\Controllers\Api\User\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CheckCartController extends Controller
{
    // check cart
    public function __invoke(CartService $service)
    {
        return response()->json([
            'status' => 'success',
            'cart' => $service->index(),
        ]);
    }
}
