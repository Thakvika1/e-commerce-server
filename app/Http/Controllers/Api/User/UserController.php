<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'data' => [
                ...$user->toArray(),
                'image' => $user->image ? asset('storage/' . $user->image) : null
            ]
        ], 200);
    }
}
