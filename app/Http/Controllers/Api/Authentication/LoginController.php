<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $r)
    {
        // convert email to lowercase
        $r['email'] = strtolower($r->email);


        $validator = Validator::make($r->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);


        // check validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // check user exists
        $userExists = Auth::attempt($validator->validated());

        // if user exists
        if ($userExists) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'user' => Auth::user(),
                'access_token' => $token,
            ], 200);
        }

        // if user not exists
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password'
        ], 401);
    }
}
