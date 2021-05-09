<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Authentication\Permission;
use App\Models\Authentication\Shortcut;
use App\Models\Authentication\User;
use App\Models\Authentication\Role;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    public function index(Request $request)
    {
        $shortcuts = Shortcut::
        with(['permission' => function ($permission) use ($request) {
            $permission->with('route')->where('institution_id', $request->institution);
        }])
            ->where('role_id', $request->role)
            ->where('user_id', $request->user()->id)
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
        $shortcut = new Shortcut();
        $shortcut->name = $request->shortcut['name'];
        $shortcut->user()->associate($request->user());
        $shortcut->role()->associate(Role::findOrFail($request->role));
        $shortcut->permission()->associate(Permission::findOrFail($request->shortcut['permission_id']));
        $shortcut->image = $request->shortcut['image'];
        $shortcut->save();

        return response()->json([
            'data' => $shortcut,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function destroy($id)
    {
        $shortcut = Shortcut::findOrFail($id);
        $shortcut->delete();
        return response()->json([
            'data' => $shortcut,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

}
