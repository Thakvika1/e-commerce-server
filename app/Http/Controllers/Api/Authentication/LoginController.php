<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\LoginRequest;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        // check user credentials
        if (Auth::attempt($request->validated())) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'user' => Auth::user(),
                'access_token' => $token,
            ], 200);
        }

        // if authentication fails
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password'
        ], 401);
    }
}
