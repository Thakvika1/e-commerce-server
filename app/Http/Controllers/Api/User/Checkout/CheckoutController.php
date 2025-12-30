<?php

namespace App\Http\Controllers\Api\User\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CheckoutService;
use Exception;

class CheckoutController extends Controller
{
    public function checkout(CheckoutService $service)
    {
        $order = $service->checkout();

        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Order successfully',
                'order' => $order->load('orderItems')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
