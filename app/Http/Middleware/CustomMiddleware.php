<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Personal_access_token;


class CustomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestToken = $request->header('Authorization');
        $tokenId = Personal_access_token::where('token', $requestToken)->first();
        if (!$tokenId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
