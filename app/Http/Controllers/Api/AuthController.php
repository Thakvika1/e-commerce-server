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
    public function register(Request $r)
    {

        // convert email to lowercase
        $r['email'] = strtolower($r->email);

        $validator = Validator::make($r->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
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


        // if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create($validator->validated());
        return response()->json([
            'status' => 'success',
            'user' => $user
        ], 201);
    }

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

    public function index(Request $r)
    {
        $user = User::paginate($r->per_page ?? 10);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function logout(Request $r)
    {
        // Logout from ALL devices
        // Auth::user()->tokens()->delete();


        // Logout only THIS device
        $r->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ], 200);
    }
}
