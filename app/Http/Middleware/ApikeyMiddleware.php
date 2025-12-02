<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ApikeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);


        // $apiKey = $request->header('x-api-key');

        // if (!$apiKey) {
        //     return response()->json([
        //         'message' => 'API key missing'
        //     ], 401);
        // }


        // return response()->json([
        //     'status' => 'success',
        //     'message' => $apiKey
        // ], 403);
    }
}
