<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseApiCrudController;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;

class AdminProductController extends BaseApiCrudController
{
    public function __construct(ProductService $service)
    {
        $this->service = $service;
        $this->storeRequest  = CreateProductRequest::class;
        $this->updateRequest = UpdateProductRequest::class;
    }
}
