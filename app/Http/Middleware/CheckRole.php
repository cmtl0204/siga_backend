<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
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
        $request->validate([
            'institution' => [
                'required',
                'integer',
            ],
            'system' => [
                'required',
                'integer',
            ],
            'role' => [
                'required',
                'integer',
            ],
        ]);

        $role = $request->user()->roles()
            ->where(function ($query) use ($request) {
                $query->where('institution_id', $request->institution)
                    ->orWhere('system_id', $request->system);
            })
            ->where('role_id', $request->role)
            ->first();

        if (!$role) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No tiene un rol asignado para el sistema o institución (check-role)',
                    'detail' => 'Comuníquese con el administrador',
                    'code' => '403'
                ]
            ], 403);
        }
        return $next($request);
    }
}
