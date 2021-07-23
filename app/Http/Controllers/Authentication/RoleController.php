<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Authentication\Permission;
use App\Models\Authentication\Role;
use App\Models\Authentication\User;
use App\Models\App\Institution;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::
        whereHas('institution', function ($institutions) use ($request) {
            $institutions->where('institutions.id', $request->institution);
        })
            ->with(['users' => function ($users) use ($request) {
                $users->whereHas('institutions', function ($institutions) use ($request) {
                    $institutions->where('institutions.id', $request->institution);
                });
            }])
            ->with(['permissions' => function ($permissions) use ($request) {
                $permissions->where('institution_id', $request->institution)->with('route');
            }])->orderBy('name')->get();

        return response()->json([
            'data' => $roles,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function getPermissions(Request $request)
    {
        $roles = Role::
        whereHas('institution', function ($institutions) use ($request) {
            $institutions->where('institutions.id', $request->institution);
        })
            ->with(['permissions' => function ($permissions) use ($request) {
                $permissions->where('institution_id', $request->institution)->with(['route'=>function($route){
                    $route->with('status')->with('module')->with('type');
                }]);
            }])->orderBy('name')->get();

        return response()->json([
            'data' => $roles,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function getUsers(Request $request)
    {
        $users = User::
        whereHas('institutions', function ($institutions) use ($request) {
            $institutions->where('institutions.id', $request->institution);
        })
            ->with(['roles' => function ($roles) use ($request) {
                $roles
                    ->with('system')
                    ->with(['permissions' => function ($permissions) {
                        $permissions->with(['route' => function ($route) {
                            $route->with('module')->with('type')->with('images')->with('status');
                        }])->with('institution');
                    }]);
            }])
            ->orderBy('first_lastname')
            ->get();

        return response()->json(['data' => $users,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function assignRole(Request $request)
    {
        $data = $request->json()->all();

        $role = Role::findOrFail($data['role_id']);
        $user = User::findOrFail($data['user_id']);

        $user->roles()->syncWithoutDetaching($role->id);

        return response()->json(['data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function removeRole(Request $request)
    {
        $data = $request->json()->all();
        $role = Role::findOrFail($data['role_id']);
        $user = User::findOrFail($data['user_id']);

        $user->roles()->detach($role->id);

        return response()->json(['data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function update(Request $request, $roleId) 
    {
        $role = Role::find($roleId);
        $role->name = $request->input('name');
        $role->code = $request->input('code');

        $role->save();
            return response()->json([
                'data' => $role,
                'msg' => [
                    'summary' => 'información actualizada',
                    'detail' => '',
                    'code' => '201'
                ]
            ], 201);
    }
}
