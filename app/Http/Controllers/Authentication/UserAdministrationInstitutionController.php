<?php

namespace App\Http\Controllers\Authentication;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\App\Status;
use App\Models\Authentication\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class  UserAdministrationInstitutionController extends Controller
{
    public function index(Request $request)
    {
        $system = $request->input('system');
        $institution = $request->input('institution');

        if ($request->has('search')) {
            $search = $request->input('search');

            $users = User::whereHas('roles', function ($role) use ($system) {
                $role->where('system_id', '=', $system);
            })->whereHas('institutions', function ($institutions) use ($institution) {
                $institutions->where('institutions.id', '=', $institution);
            })
                ->where(function ($query) use ($search) {
                    $query->email($search);
                    $query->firstlastname($search);
                    $query->firstname($search);
                    $query->identification($search);
                    $query->secondlastname($search);
                    $query->secondname($search);
                })
                ->with(['institutions' => function ($institutions) use ($institution) {
                    $institutions->orderBy('name');
                    $institutions->where('institutions.id', '=', $institution);
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
            })->whereHas('institutions', function ($institutions) use ($institution) {
                $institutions->where('institutions.id', '=', $institution);
            })
                ->with(['institutions' => function ($institutions) use ($institution) {
                    $institutions->orderBy('name');
                    $institutions->where('institutions.id', '=', $institution);
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
        return response()->json([
            'data' => $users,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    public function show($idUser, Request $request)
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
            ->where('id', $idUser)
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
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->second_name = $request->input('second_name');
        $user->first_lastname = $request->input('first_lastname');
        $user->second_lastname = $request->input('second_lastname');
        $user->birthdate = $request->input('birthdate');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->status()->associate(Status::getInstance($request->input('status')));
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
            $user->username = $request->input('username');
            $user->first_name = $request->input('first_name');
            $user->first_lastname = $request->input('first_lastname');
            $user->birthdate = $request->input('birthdate');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');

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

    public function destroy($userId, Request $request)
    {
        $system = $request->input('system');
        $user = User::whereHas('roles', function ($role) use ($system) {
            $role->where('system_id', '=', $system);
        })->where('id', $userId)
            ->get();

        if (sizeof($user) === 0) {
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
            $user->delete();

            return response()->json([
                'data' => $user,
                'msg' => [
                    'summary' => 'deleted',
                    'detail' => '',
                    'code' => '201'
                ]
            ], 201);
        }
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
}
