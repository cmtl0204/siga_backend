<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Authentication\Permission;
use App\Models\Authentication\Shortcut;
use App\Models\Authentication\Role;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    public function index(Request $request)
    {
        $shortcuts = $request->user()->shortcuts()
            ->with(['permission' => function ($permission) use ($request) {
                $permission->with('route')
                    ->where('institution_id', $request->institution)
                    ->orWhere('system_id', $request->system);
            }])
            ->where('role_id', $request->role)
            ->get();
        return response()->json([
            'data' => $shortcuts,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function store(Request $request)
    {
        $permission = Permission::getInstance($request->shortcut['permission_id']);
        $role = Role::getInstance($request->role);

        $shortcut = new Shortcut();
        $shortcut->name = $request->shortcut['name'];
        $shortcut->image = $request->shortcut['image'];
        $shortcut->user()->associate($request->user());
        $shortcut->role()->associate($role);
        $shortcut->permission()->associate($permission);
        $shortcut->save();

        return response()->json([
            'data' => $shortcut,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function destroy(Shortcut $shortcut)
    {
        $shortcut->delete();

        return response()->json([
            'data' => $shortcut,
            'msg' => [
                'summary' => 'El acceso directo ha sido eliminado',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }
}
