<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Requests\JobBoard\Company\IndexCompanyRequest;
use App\Models\App\Status;
//Controllers
use App\Http\Controllers\Controller;

//Models
use App\Models\App\Catalogue;
use App\Models\App\Address;
use App\Models\Authentication\User;
use App\Models\JobBoard\Company;


// FormRequest
use App\Http\Requests\JobBoard\Company\StoreCompanyRequest;
use App\Http\Requests\JobBoard\Company\UpdateCompanyRequest;
use App\Http\Requests\JobBoard\Company\GetCompanyRequest;
use App\Models\JobBoard\Professional;


class CompanyController extends Controller
{


function test(){

}

    function getProfesionals(IndexCompanyRequest $request){
        $company = $request->user()->company()->first();
        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$company) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Empresa no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        if ($request->has('search')) {
            $professionals = $company->professionals()
                ->paginate($request->input('per_page'));
        } else {
            $professionals = $company->professionals()->paginate($request->input('per_page'));
        }

        if (sizeof($professionals) === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron profesionales en esta compañia',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($professionals, 200);

    }
    function detachProfessional(IndexCompanyRequest $request){
        $company = $request->user()->company()->first();
        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$company) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Empresa no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }
        $professional = $company->professionals()->detach($request->input('professional_id'));

        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }
    function getCompany(GetCompanyRequest $request)
    {
        $company = $request->user()->company()->first();
        if(!$company){
            return response()->json([
                'data' => $company,
                'msg' => [
                    'summary' => 'Company no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404',
                ]], 404);
        }
        return response()->json([
            'data' => $company,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200',
            ]], 200);
    }
    function register(StoreCompanyRequest  $request)
    {

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo company.

        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $address = Address::getInstance($request->input('address.id'));
        $identificationType = Catalogue::getInstance($request->input('identificationType.id'));
        $status = Status::firstWhere('code',$catalogues['status']['inactive']);

        $user = new User();
        $user->username = $request->input('user.username');
        $user->identification= $request->input('user.identification');
        $user->email = $request->input('user.email');
        $user->password = $request->input('user.password');
        $user->address()->associate($address);
        $user->identificationType()->associate($identificationType);
        $user->status()->associate($status);

        $user->save();

        $type = Catalogue::getInstance($request->input('type.id'));
        $activityType = Catalogue::getInstance($request->input('activityType.id'));
        $personType = Catalogue::getInstance($request->input('personType.id'));

        $company = new Company();

        $company->trade_name =$request->input('company.trade_name');

        $company->comercial_activities = $request->input('company.comercial_activities');
        $company->web = $request->input('company.web');
        $company->user()->associate($user);
        $company->activityType()->associate($activityType);
        $company->type()->associate($type);
        $company->personType()->associate($personType);
        $company->save();

        return response()->json([
            'data' => $company,
            'msg' => [
                'summary' => 'Empresa creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);


    }
    function updateCompany(UpdateCompanyRequest $request){
        // Crea una instanacia del modelo Catalogue para poder actualizar en el modelo Company.
        $type = Catalogue::getInstance($request->input('type.id'));
        $activityType = Catalogue::getInstance($request->input('activityType.id'));
        $personType = Catalogue::getInstance($request->input('personType.id'));
        $company = $request->user()->company()->first();
        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$company) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Empresa no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }
        $company->trade_name = $request->input('company.trade_name');
        $company->comercial_activities = $request->input('company.comercial_activities');
        $company->web = $request->input('company.web');
        $company->activityType()->associate($activityType);
        $company->type()->associate($type);
        $company->personType()->associate($personType);
        $company->save();

        return response()->json([
            'data' => $company,
            'msg' => [
                'summary' => 'Empresa actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);

    }


}
