<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Example data for dashboard
        $data = [
            'total_users' => 1500,
            'total_orders' => 3200,
            'total_revenue' => 75000,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}
