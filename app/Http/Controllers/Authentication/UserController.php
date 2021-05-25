<?php

namespace App\Http\Controllers\Authentication;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\User\UserCreateRequest;
use App\Http\Requests\Authentication\UserRequest;
use App\Models\Authentication\PassworReset;
use App\Models\Authentication\Role;
use App\Models\App\Catalogue;
use App\Models\Authentication\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class  UserController extends Controller
{
    public function show($username, Request $request)
    {
        $user = User::
        with('ethnicOrigin')
            ->with('address')
            ->with('identificationType')
            ->with('sex')
            ->with('gender')
            ->with('bloodType')
            ->with('roles')
            ->where('username', $username)
            ->first();

        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $dataUser = $data['user'];
        $user = User::findOrFail($dataUser['id']);
        $user->identification = $dataUser['identification'];
        $user->username = strtoupper(trim($dataUser['username']));
        $user->first_name = strtoupper(trim($dataUser['first_name']));
        $user->first_lastname = strtoupper(trim($dataUser['first_lastname']));
        $user->birthdate = trim($dataUser['birthdate']);
        $user->email = strtolower(trim($dataUser['email']));

        $ethnicOrigin = Catalogue::findOrFail($dataUser['ethnic_origin']['id']);
        $location = Catalogue::findOrFail($dataUser['location']['id']);
        $identificationType = Catalogue::findOrFail($dataUser['identification_type']['id']);
        $sex = Catalogue::findOrFail($dataUser['sex']['id']);
        $gender = Catalogue::findOrFail($dataUser['gender']['id']);
        $state = Catalogue::where('code', '1')->first();
        $user->ethnicOrigin()->associate($ethnicOrigin);
        $user->location()->associate($location);
        $user->identificationType()->associate($identificationType);
        $user->sex()->associate($sex);
        $user->gender()->associate($gender);
        $user->state()->associate($state);
        $user->save();
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'update',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function updateAuth(Request $request)
    {
        $data = $request->json()->all();
        $dataUser = $data['user'];
        $user = User::findOrFail($dataUser['id']);
        $user->identification = $dataUser['identification'];
        $user->username = strtoupper(trim($dataUser['username']));
        $user->first_name = strtoupper(trim($dataUser['first_name']));
        $user->first_lastname = strtoupper(trim($dataUser['first_lastname']));
        $user->birthdate = trim($dataUser['birthdate']);
        $user->email = strtolower(trim($dataUser['email']));

        $ethnicOrigin = Catalogue::findOrFail($dataUser['ethnic_origin']['id']);
        $location = Catalogue::findOrFail($dataUser['location']['id']);
        $identificationType = Catalogue::findOrFail($dataUser['identification_type']['id']);
        $sex = Catalogue::findOrFail($dataUser['sex']['id']);
        $gender = Catalogue::findOrFail($dataUser['gender']['id']);
        $state = Catalogue::where('code', '1')->first();
        $user->ethnicOrigin()->associate($ethnicOrigin);
        $user->location()->associate($location);
        $user->identificationType()->associate($identificationType);
        $user->sex()->associate($sex);
        $user->gender()->associate($gender);
        $user->state()->associate($state);
        $user->save();
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'update',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function uploadAvatar(Request $request)
    {
        $file = $request->file('file');
        if ($file) {
            $user = $request->user();
            Storage::delete($user->avatar);

            $filePath = $file->storeAs('avatars', $user->id . '.' . $file->getClientOriginalExtension(), 'public');

            $user->update(['avatar' => $filePath]);
            return response()->json([
                'data' => $user->avatar,
                'msg' => [
                    'summary' => 'upload',
                    'detail' => '',
                    'code' => '201'
                ]], 201);
        } else {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Archivo no valido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
    }
}
