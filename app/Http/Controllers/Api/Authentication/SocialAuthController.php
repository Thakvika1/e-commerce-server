<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;


class SocialAuthController extends Controller
{
    /**
     * Validate provider
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return response()->json(['error' => 'Invalid provider'], 422);
        }
        return null;
    }


    /**
     * Redirect to provider
     */
    // public function redirectToProvider($provider)
    // {
    //     $validated = $this->validateProvider($provider);
    //     if (!is_null($validated)) {
    //         return $validated;
    //     }

    //     return Socialite::driver($provider)->stateless()->redirect();
    // }
}
