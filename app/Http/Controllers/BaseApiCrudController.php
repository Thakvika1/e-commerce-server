<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseApiCrudController extends Controller
{
    protected $service;
    protected string $storeRequest;
    protected string $updateRequest;

    public function index(Request $request)
    {

        $data = $this->service->paginate($request->per_page ?? 10)
            ?? $this->service->index();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    // create data
    public function store($product_id)
    {
        $validated = app($this->storeRequest)->validated();
        $data = $this->service->create($validated) ?? $this->service->add($product_id);

        return $data;
    }

    // detail data
    public function show($id)
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->service->findOrFail($id)
        ], 200);
    }

    // update data
    public function update($id)
    {
        $validated = app($this->updateRequest)->validated();

        return response()->json([
            'status' => 'success',
            'data' => $this->service->update($id, $validated)
        ]);
    }

    // delete data
    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Deleted successful',
        ]);
    }
}
