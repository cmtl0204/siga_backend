<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Authentication\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::with('route')
            ->where('institution_id', $request->institution_id)
            ->get();

        return response()->json(['data' => $permissions, 'msg' => [
            'summary' => 'success',
            'detail' => '',
            'code' => '200'
        ]], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Permission $permission)
    {
        //
    }

    public function update(Request $request, Permission $permission)
    {
        //
    }

    public function destroy(Permission $permission)
    {
        //
    }
}
