<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInstitutionRequest;
use App\Http\Requests\UpdateInstitutionRequest;
use App\Models\Authentication\Permission;
use App\Models\Authentication\Role;
use App\Models\Authentication\User;
use App\Models\Cecy\Institution;

use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $institutions = Institution::where('code', 'like', '%' . $request->search . '%')
                ->orWhere('name', 'like', '%' . $request->search . '%')
                ->limit(1000)
                ->get();
        } else {
            $institutions = Institution::all();
        }

        return response()->json([
            'data' => [
                'attributes' => $institutions,
                'type' => 'institutions'
            ]
        ], 200);
    }

    public function store(CreateInstitutionRequest $request)
    {
        $data = $request->all();
        $state = State::firstWhere('code', State::ACTIVE);
        $institution = $state->institution()->create($data);
        return response()->json([
            'data' => [
                'attributes' => $institution,
                'type' => 'institution'
            ]
        ], 201);
    }

    public function show(Institution $institution)
    {
        return $institution;
    }

    public function update(UpdateInstitutionRequest $request, Institution $institution)
    {
        $data = $request->all();
        $institution = $institution->update($data);
        return response()->json([
            'data' => [
                'attributes' => $institution,
                'type' => 'institution'
            ]
        ], 201);
    }

    public function destroy($id)
    {
        $state = State::where('code', '3')->first();
        $institution = Institution::findOrFail($id);
        $institution->state()->associate($state);
        $institution->update();
        return response()->json([
            'data' => [
                'attributes' => $institution,
                'type' => 'institution'
            ]
        ], 201);
    }

    public function assignInstitution(Request $request)
    {
        $data = $request->json()->all();

        $institution = Institution::findOrFail($data['institution_id']);
        $user = User::findOrFail($data['user_id']);

        $user->institutions()->syncWithoutDetaching($institution->id);

        return response()->json(['data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function removeInstitution(Request $request)
    {
        $data = $request->json()->all();
        $institution = Institution::findOrFail($data['institution_id']);
        $user = User::findOrFail($request->user_id);
        $roles = Role::where('institution_id', $data['institution_id'])->get();

        foreach ($roles as $role) {
            $user->roles()->detach($role->id);
        }
        $user->institutions()->detach($institution->id);

        return response()->json(['data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }
}
