<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => $data
        ]);
    }
}
