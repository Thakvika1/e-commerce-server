<?php

namespace App\Trait;

trait ApiResponseTrait
{
    public function success($data, $message)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error($message)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 400);
    }
}
