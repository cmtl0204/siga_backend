<?php

namespace App\Http\Middleware;

use App\Models\Authentication\Role;
use Closure;
use Illuminate\Http\Request;

class CheckPermissions
{
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'uri' => [
                'required',
            ]
        ]);

        $role = Role::findOrFail($request->role);
        $allPermission = $role->permissions()
            ->whereHas('route', function ($route) use ($request) {
                $route->where('uri', $request->uri);
            })
            ->first();

        $permission = $role->permissions()
            ->whereHas('route', function ($route) use ($request) {
                $route->where('uri', $request->uri);
            })
            ->whereJsonContains('actions', $request->getMethod())
            ->first();

        $actions = null;

        if ($allPermission) {
            $actions = implode(', ', $allPermission->actions);
        }

        if (!$permission) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => "No tiene permiso para acceder a la ruta: [{$request->uri}] " .
                        "y ejecutar la acción: [{$request->getMethod()}] (check-permissions)",
                    'detail' => "Acciones permitidas: [{$actions}]",
                    'code' => '403'
                ]
            ], 403);
        }
        return $next($request);
    }
}
