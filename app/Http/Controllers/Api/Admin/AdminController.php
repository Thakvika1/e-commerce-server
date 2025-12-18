<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // user data
        $userData = User::paginate($request->per_page ?? 10);

        // product data
        $productData = Product::paginate($request->per_page ?? 10);

        // order data
        $invoice = OrderItem::with('Product')->paginate($request->per_page ?? 10);

        return response()->json([
            'status' => 'success',
            'user data' => $userData,
            'product data' => $productData,
            'invoice' => $invoice,
        ], 200);
    }
}
