<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Authentication\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function getMenus(Request $request)
    {
        $modules = Module::where('system_id', $request->system)
            ->with(['routes' => function ($routes) use ($request) {
                $routes->whereHas('permission', function ($permission) use ($request) {
                    $permission->whereHas('roles', function ($roles) use ($request) {
                        $roles->where('roles.id', $request->role);
                    });
                })->with('type');
            }])->whereHas('routes')
            ->get();

        return response()->json([
            'data' => $modules,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }
}
