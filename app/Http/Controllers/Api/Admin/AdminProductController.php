<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Product\CreateProductRequest;

class AdminProductController extends BaseCrudController
{
    public function __construct()
    {
        $this->model = Product::class;


        $this->validateData = [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|url',
        ];

        $this->validateUpdateData = [
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'image' => 'sometimes|nullable|url',
        ];
    }
}
