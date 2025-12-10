<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\BaseCrudController;

class AdminCategoryController extends BaseCrudController
{

    public function __construct()
    {
        $this->model = Category::class;

        $this->validateData = [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ];

        $this->validateUpdateData = [
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
        ];
    }
}
