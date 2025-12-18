<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = Product::with('category')->paginate($request->per_page ?? 10);

        return response()->json(
            [
                'status' => 'success',
                'data' => $data
            ],
            200
        );
    }

    public function show(Request $request, $id)
    {
        $item = Product::find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 200);
        }
    }


}
