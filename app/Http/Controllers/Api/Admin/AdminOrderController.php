<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Exception;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $data = Order::paginate($request->per_page ?? 10);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'staus' => 'error',
                'message' => 'Order not found',
            ], 404);
        }
        try {
            $order->status = $request->status;
            $order->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Status must be (pending, confirmed, shipped, completed)',
            ]);
        }



        return response()->json([
            'status' => 'success',
            'message' => 'Update success',
        ], 200);
    }
}
