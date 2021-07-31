<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Requests\JobBoard\Company\IndexCompanyRequest;
use App\Http\Requests\JobBoard\Company\VerifyRequest;
use App\Models\App\Status;

//Controllers
use App\Http\Controllers\Controller;

//Models
use App\Models\App\Catalogue;
use App\Models\App\Address;
use App\Models\Authentication\User;
use App\Models\JobBoard\Company;
use App\Models\App\Location;


// FormRequest
use App\Http\Requests\JobBoard\Company\StoreCompanyRequest;
use App\Http\Requests\JobBoard\Company\UpdateCompanyRequest;
use App\Http\Requests\JobBoard\Company\GetCompanyRequest;
use App\Models\JobBoard\Professional;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
    function getProfessionals(IndexCompanyRequest $request)
    {
        $company = $request->user()->company()->first();
        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$company) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Empresa no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]
            ], 404);
        }
        if ($request->has('search')) {
            $professionals = $company->professionals()
                ->paginate($request->input('per_page'));
        } else {
            $professionals = $company->professionals()->paginate($request->input('per_page'));
        }

        return response()->json($professionals, 200);
    }

    function detachProfessional(IndexCompanyRequest $request)
    {
        $company = $request->user()->company()->first();
        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$company) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Empresa no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]
            ], 404);
        }
        $professional = $company->professionals()->detach($request->input('professional_id'));

        return response()->json([
            'data' => $professional,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    function getCompany(GetCompanyRequest $request)
    {
        $company = $request->user()->company()
            ->with('activityType', 'type', 'personType')
            ->with(['user' => function ($user) {
                $user->with('identificationType')
                    ->with(['address' => function ($address) {
                        $address->with([
                            'location' => function ($location) {
                                $location->with('parent');
                            }, 'sector']);
                    }]);
            }])->first();
        if (!$company) {
            return response()->json([
                'data' => $company,
                'msg' => [
                    'summary' => 'Company no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404',
                ]
            ], 404);
        }
        return response()->json([
            'data' => $company,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200',
            ]
        ], 200);
    }

    function register(StoreCompanyRequest $request)
    {
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo company.

        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $location = Location::getInstance($request->input('company.user.address.location.id'));
        $sector = Catalogue::getInstance($request->input('company.user.address.sector.id'));
        $address = new Address;
        $address->main_street = $request->input('company.user.address.main_street');
        $address->secondary_street = $request->input('company.user.address.secondary_street');
        $address->number = $request->input('company.user.address.number');
        $address->post_code = $request->input('company.user.address.post_code');
        $address->reference = $request->input('company.user.address.reference');
        $address->longitude = $request->input('company.user.address.longitude');
        $address->latitude = $request->input('company.user.address.latitude');
        $address->location()->associate($location);
        $address->sector()->associate($sector);
        $address->save();

        $identificationType = Catalogue::find($request->input('company.user.identification_type.id'));
        $status = Status::firstWhere('code', $catalogues['status']['inactive']);

        $user = new User();
        $user->username = $request->input('company.user.identification');
        $user->identification = $request->input('company.user.identification');
        $user->email = $request->input('company.user.email');
        $user->password = $request->input('company.user.password');
        $user->address()->associate($address);
        $user->identificationType()->associate($identificationType);
        $user->status()->associate($status);

        $user->save();

        $type = Catalogue::find($request->input('company.type.id'));
        $activityType = Catalogue::find($request->input('company.activity_type.id'));
        $personType = Catalogue::find($request->input('company.person_type.id'));

        $company = new Company();

        $company->trade_name = $request->input('company.trade_name');
        $company->prefix = $request->input('company.prefix');
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
            ]
        ], 201);
    }

    function updateCompany(UpdateCompanyRequest $request)
    {
        // Crea una instanacia del modelo Catalogue para poder actualizar en el modelo Company.
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $user = $request->user();
        $address = $user->address()->first() ? $user->address()->first() : new Address();
        $location = Location::find($request->input('company.user.address.location.id'));
        $sector = Catalogue::find($request->input('company.user.address.sector.id'));
        $address->main_street = $request->input('company.user.address.main_street');
        $address->secondary_street = $request->input('company.user.address.secondary_street');
        $address->number = $request->input('company.user.address.number');
        $address->post_code = $request->input('company.user.address.post_code');
        $address->reference = $request->input('company.user.address.reference');
        $address->longitude = $request->input('company.user.address.longitude');
        $address->latitude = $request->input('company.user.address.latitude');
        $address->location()->associate($location);
        $address->sector()->associate($sector);
        $address->save();

        $identificationType = Catalogue::find($request->input('company.user.identification_type.id'));
        $user->username = $request->input('company.user.identification');
        $user->identification = $request->input('company.user.identification');
        $user->email = $request->input('company.user.email');
        $user->phone = $request->input('company.user.phone');
        $user->cellphone = $request->input('company.user.cellphone');
        $user->identificationType()->associate($identificationType);
        $user->address()->associate($address);
        $user->save();

        $type = Catalogue::find($request->input('company.type.id'));
        $activityType = Catalogue::find($request->input('company.activity_type.id'));
        $personType = Catalogue::find($request->input('company.person_type.id'));
        $company = $request->user()->company()->first();
        $company->trade_name = $request->input('company.trade_name');
        $company->prefix = $request->input('company.prefix');
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
            ]
        ], 201);
    }

    function verifyCompany(VerifyRequest $request)
    {
        $user = User::with('company')->where('username', '=', $request->input('identification'))
            ->orWhere('identification', '=', $request->input('identification'))->first();
        if (!$user) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Empresa no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '200'
                ]
            ], 200);
        }
        return response()->json([
            'data' => $user,
            'msg' => [
                'summary' => 'Empresa existente',
                'detail' => 'Vuelva a intentar',
                'code' => '200'
            ]
        ], 200);
    }
}
