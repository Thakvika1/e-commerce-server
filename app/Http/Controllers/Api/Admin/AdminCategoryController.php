<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseApiCrudController;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;


class AdminCategoryController extends BaseApiCrudController
{
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
        $this->storeRequest  = CreateCategoryRequest::class;
        $this->updateRequest = UpdateCategoryRequest::class;
    }
}
