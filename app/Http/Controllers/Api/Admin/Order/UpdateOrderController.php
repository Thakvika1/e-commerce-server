<?php

namespace App\Http\Controllers\Api\Admin\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CheckoutService;
use App\Http\Requests\Order\UpdateOrderRequest;

class UpdateOrderController extends Controller
{
    public function update(CheckoutService $service, UpdateOrderRequest $request, $id)
    {
        $order = $service->updateOrder($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Update success',
            'order' => $order->load('orderItems')
        ], 200);
    }
}
