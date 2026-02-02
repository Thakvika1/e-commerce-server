<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\EditProfileFormRequest;
use Illuminate\Support\Facades\Auth;

class EditProfileController extends Controller
{
    public function editProfile(EditProfileFormRequest $request)
    {

        try {
            $id = Auth::user()->id;
            $user = User::find($id);

            $user->update($request->validated());

            return response()->json([
                'status' => 'success',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
