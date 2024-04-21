<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()) {
            return response()->json(
                [
                    "code" => 403,
                    "message" => "Login failed",
                ],
                403
            );
        }
        return $next($request);
    }
}
