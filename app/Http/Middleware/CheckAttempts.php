<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAttempts
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
        if ($request->user()->attempts <= 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Oops! Su usuario ha sido bloqueado! (check-attempts)',
                    'detail' => 'Demasiados intentos de inicio de sesión',
                    'code' => '429'
                ]
            ], 429);
        }
        return $next($request);
    }
}
