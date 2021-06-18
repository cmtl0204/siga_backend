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
//funcion  store
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

    function update(UpdateInstitutionRequest $request, $id)
    {
     
       $institutions= Institutions::find($id);
       $institutions -> ruc = $request ->input('institution.ruc');
       $institutions -> logo = $request ->input('institution.logo');
       $institutions -> name = $request ->input('institution.name');
       $institutions -> slogan = $request ->input('institution.slogan');
       $institutions -> code = $request ->input('institution.code');
      // $institutions -> authority() -> associate(Authority::find($request ->input('institution.authority_id')));
       //$institutions -> institution()-> associate (Institutions::find($request->input('institution.institution_id')));
       $institutions -> save();
        return response()->json([
            'data' => [
                'attributes' => $institutions,
                'type' => 'institution'
            ]
        ], 201);
    }

    
    function destroy($id)
    {
    Institutions::destroy($id); //borrado logico
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Registro(s) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
    
}
