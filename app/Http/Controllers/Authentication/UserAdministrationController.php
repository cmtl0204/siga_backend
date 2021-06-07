<?php

namespace App\Http\Controllers\Authentication;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\User\UserCreateRequest;
use App\Http\Requests\Authentication\UserAdministration\UserAdminIndexRequest;
use App\Http\Requests\Authentication\UserRequest;
use App\Models\Authentication\PassworReset;
use App\Models\Authentication\Role;
use App\Models\App\Catalogue;
use App\Models\App\Status;
use App\Models\Authentication\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class  UserAdministrationController extends Controller
{
    public function index(Request $request)
    {
        $system = $request->input('system');
        $search = $request->input('search');

        if ($request->has('search')) {
            $users = User::whereHas('roles', function ($role) use ($system) {
                $role->where('system_id', '=', $system);
            })
                ->where(function ($query) use ($search) {
                    $query->email($search);
                    $query->firstlastname($search);
                    $query->names($search);
                    $query->identification($search);
                    $query->secondlastname($search);
                })
                ->with(['institutions' => function ($institutions) {
                    $institutions->orderBy('name');
                }])
                ->with(['roles' => function ($roles) use ($request) {
                    $roles
                        ->with(['permissions' => function ($permissions) {
                            $permissions->with(['route' => function ($route) {
                                $route->with('module')->with('type')->with('status');
                            }])->with('institution');
                        }]);
                }])
                ->paginate($request->input('per_page'));
        } else {
            $users = User::whereHas('roles', function ($role) use ($system) {
                $role->where('system_id', '=', $system);
            })
                ->with(['institutions' => function ($institutions) {
                    $institutions->orderBy('name');
                }])
                ->with(['roles' => function ($roles) use ($request) {
                    $roles
                        ->with(['permissions' => function ($permissions) {
                            $permissions->with(['route' => function ($route) {
                                $route->with('module')->with('type')->with('status');
                            }])->with('institution');
                        }]);
                }])
                ->paginate($request->input('per_page'));
        }

        if ($users->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron usuarios',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($users, 200);
    }

    public function show($userId, Request $request)
    {
        $system = $request->input('system');
        $user = User::whereHas('roles', function ($role) use ($system) {
            $role->where('system_id', '=', $system);
        })
            ->with(['institutions' => function ($institutions) {
                $institutions->orderBy('name');
            }])
            ->with(['roles' => function ($roles) use ($request) {
                $roles->with(['permissions' => function ($permissions) {
                    $permissions->with(['route' => function ($route) {
                        $route->with('module')->with('type')->with('status');
                    }])->with('institution');
                }]);
            }])
            ->where('id', $userId)
            ->first();
        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al usuario',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->identification = $request->input('identification');
        $user->username = $request->input('identification');
        $user->first_name = $request->input('names');
        $user->first_lastname = $request->input('first_lastname');
        $user->second_lastname = $request->input('second_lastname');
        $user->email = $request->input('email');

        $user->status()->associate(Status::getInstance($request->input('user.status')));
        $user->save();

        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(Request $request, $userId)
    {
        $system = $request->input('system');
        $user = User::whereHas('roles', function ($role) use ($system) {
            $role->where('system_id', '=', $system);
        })->where('id', $userId)
            ->get();

        if ($user->count() == 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Usuario no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        } else {
            $user = User::find($userId);
            $user->identification = $request->input('identification');
            $user->username = $request->input('identification');
            $user->first_name = $request->input('names');
            $user->first_lastname = $request->input('first_lastname');
            $user->second_lastname = $request->input('second_lastname');
            $user->email = $request->input('email');

            $user->save();
            return response()->json([
                'data' => $user,
                'msg' => [
                    'summary' => 'update',
                    'detail' => '',
                    'code' => '201'
                ]
            ], 201);
        }
    }

    public function delete(Request $request)
    {        
         User::destroy($request->input('ids'));
         
                 return response()->json([
                     'data' => null,
                     'msg' => [
                         'summary' => 'Usuario(s) eliminado(s)',
                         'detail' => 'Se eliminó correctamente',
                         'code' => '201'
                     ]], 201);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    private function filter($conditions)
    {
        $filters = array();
        foreach ($conditions as $condition) {
            if ($condition['match_mode'] === 'contains') {
                array_push($filters, array($condition['field'], $condition['logic_operator'], '%' . $condition['value'] . '%'));
            }
            if ($condition['match_mode'] === 'start') {
                array_push($filters, array($condition['field'], $condition['logic_operator'], $condition['value'] . '%'));
            }
            if ($condition['match_mode'] === 'end') {
                array_push($filters, array($condition['field'], $condition['logic_operator'], '%' . $condition['value']));
            }
        }
        return $filters;
    }

    public function getRoles(Request $request){

        $user = User::find($request->input('id'));
        $roles = $user->roles()
        ->where('system_id', $request->input('system'))
        ->get();

        if ($roles->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No tiene roles asignados',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json([
            'data' => $roles,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }
}
