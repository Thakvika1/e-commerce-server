<?php

namespace App\Http\Controllers\Api\Admin\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CheckoutService;

class OrderListController extends Controller
{
    public function index(CheckoutService $service, Request $request)
    {
        $data = $service->orderList($request->per_page);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }
}
