<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function index(Request $request, ProductService $service)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => $service->paginate($request->per_page ?? 10)
            ],
            200
        );
    }

    public function show(ProductService $service, $id)
    {
        return response()->json([
            'status' => 'success',
            'item' => $service->find($id)
        ], 200);
    }
}
