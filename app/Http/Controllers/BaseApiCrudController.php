<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

abstract class BaseApiCrudController extends Controller
{
    protected $service;
    protected string $storeRequest;
    protected string $updateRequest;

    public function index(Request $request)
    {

        // http://127.0.0.1:8000/storage/


        $data = $this->service->paginate($request->per_page ?? 15)
            ?? $this->service->index();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    // create data
    public function store()
    {
        $validated = app($this->storeRequest)->validated();


        // if (isset($validated['image'])) {

        //     $path = $validated['image']->store('products', 'public');
        //     // dd($path);

        //     $validated['image'] = $path;
        //     // dd($validated);
        // }

        if (app($this->storeRequest)->hasFile('image')) {
            $validated['image'] =  $validated['image']->store('products', 'public');

            // Store in PRIVATE storage (not public)
            // $path = basename($validated['image']->store('products'));

            // Get only the filename
            // $filename = basename($path);

            // dd($filename);

            // Save only the path in DB (not full URL)
            // $validated['image'] = $path;
        }

        $data = $this->service->create($validated);

        try {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    // detail data
    public function show($id)
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->service->find($id)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
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
