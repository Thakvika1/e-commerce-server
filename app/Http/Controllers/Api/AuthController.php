<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
            // 'password' => [
            //     'required',
            //     'string',
            //     'min:8',             // must be at least 8 characters in length
            //     'regex:/[a-z]/',      // must contain at least one lowercase letter
            //     'regex:/[A-Z]/',      // must contain at least one uppercase letter
            //     'regex:/[0-9]/',      // must contain at least one digit
            //     'regex:/[@$!%*#?&]/'  // must contain a special character
            // ]
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validated->errors()
            ], 422);
        }

        $data = $validated->validated();


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);


        // check validation fails
        $validated_fails = $validator->fails();
        if ($validated_fails) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // get validated data
        $validated = $validator->validated();

        // check user exists
        $userExists = Auth::attempt($validated);

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
