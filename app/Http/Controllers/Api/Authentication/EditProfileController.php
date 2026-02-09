<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\EditProfileFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    public function editProfile(EditProfileFormRequest $request)
    {

        try {
            $user = User::find(Auth::user()->id);

            $validated = $request->validated();

            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($user->image && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }

                // store the file and get path
                $path = $request->file('image')->store('users', 'public');
                $validated['image'] = $path;
            }

            // dd($validated);

            $user->update($validated);

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
