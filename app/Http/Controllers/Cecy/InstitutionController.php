<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Models\Authentication\Permission;
use App\Models\Authentication\Role;
use App\Models\Authentication\User;
use App\Models\Cecy\Institutions;
use App\Models\App\Institution;

use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Institutions\IndexInstitutionRequest;
use App\Http\Requests\Cecy\Institutions\CreateInstitutionRequest;
use App\Http\Requests\Cecy\Institutions\DeleteInstitutionRequest;
use App\Http\Requests\Cecy\Institutions\UpdateInstitutionRequest;


class InstitutionController extends Controller
{
    public function index(IndexInstitutionRequest $request)
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

    public function store(Request $request)
    {
        $data = $request->all();
       // $institution = $state->institution()->create($data);
       $institutions = $data ['institution']['institution'];
       //$authority= $data ['institution']['authority'];
       $institution = new Institutions();
       $institution -> ruc = $request ->input('institution.ruc');
       $institution -> logo = $request ->input('institution.logo');
       $institution -> name = $request ->input('institution.name');
       $institution -> slogan = $request ->input('institution.slogan');
       $institution -> code = $request ->input('institution.code');
       $institution -> authority_id = $request ->input('institution.authority_id');
       $institution -> institution()-> associate (Institution::findOrFail($institutions['id']));
       $institution -> save();


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

    
    function delete(DeleteInstitutionRequest $request)
    {
        Institution::destroy($request->input("ids")); 
        // Es una eliminación lógica

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Detalle(es) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
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
