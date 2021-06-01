<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = config('auth.api_token');
        if (!$token) {
            abort(500);
        }

        // Dummy token authentication
        $authHeader = $request->header('Authorization');
        if (!$authHeader || !Str::startsWith($authHeader, 'Bearer ')) {
            abort(403);
        }

        if (substr($authHeader, 7) !== $token) {
            abort(403);
        }

        return $next($request);
    }
}
