<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderHistory;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Example data for dashboard
        $data = [
            'total_users' => 1500,
            'total_orders' => 3200,
            'total_revenue' => 75000,
        ];

        // user data
        $userData = User::paginate($request->per_page ?? 10);

        // product data
        $productData = Product::paginate($request->per_page ?? 10);

        // order data
        $orderHistory = OrderHistory::paginate($request->per_page ?? 10);

        return response()->json([
            'status' => 'success',
            'user data' => $userData,
            'product data' => $productData,
            'order history' => $orderHistory,
        ], 200);
    }
}
