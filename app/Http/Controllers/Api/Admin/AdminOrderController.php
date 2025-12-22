<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Exception;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Order\UpdateOrderRequest;

class AdminOrderController extends Controller
{
    public function index(CheckoutService $service, Request $request)
    {
        $data = $service->orderList($request->per_page);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

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
