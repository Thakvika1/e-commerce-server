<?php

namespace App\Http\Controllers\Api\User\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function checkout(CheckoutService $service)
    {
        $order = $service->checkout();

        return response()->json([
            'status' => 'success',
            'message' => 'Order successfully',
            'order' => $order->load('orderItems')
        ]);
    }
}
