<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseCrudController extends Controller
{
    protected $model;        // The model class
    protected $validateData;        // for store
    protected $validateUpdateData;  // for update
    

    // list all data with pagination
    public function index(Request $request)
    {
        $data = $this->model::paginate($request->per_page ?? 10);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    // store new data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validateData);

        // validation failed
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $item = $this->model::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'data' => $item
        ], 201);
    }

    // show single item by id
    public function show($id)
    {
        $item = $this->model::find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not Found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $item
        ], 200);
    }

    // update data by id
    public function update(Request $request, $id)
    {
        $item = $this->model::find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not Found'
            ], 404);
        }

        $validator = Validator::make($request->all(), $this->validateUpdateData);

        // validation failed
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $item->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'data' => $item
        ], 200);
    }

    // delete data by id
    public function destroy($id)
    {
        $item = $this->model::find($id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not Found'
            ], 404);
        }
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Deleted'
        ], 200);
    }
}
