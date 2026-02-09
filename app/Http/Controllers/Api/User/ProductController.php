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

        $products = $service->paginate($request->per_page ?? 10);

        // Transform each product to include full image URL
        $products->getCollection()->transform(function ($product) {
            $product->image = asset('storage/' . $product->image);
            return $product;
        });

        return response()->json([
            'status' => 'success',
            'data' => $products
        ], 200);
    }

    public function show(ProductService $service, $id)
    {
        $product = $service->find($id);
        if ($product && $product->image) {
            $product->image = asset('storage/' . $product->image);
        }

        return response()->json([
            'status' => 'success',
            'item' => $product
        ], 200);
    }
}
