<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\JobBoard\Company;
use App\Models\JobBoard\Offer;
use App\Models\App\Status;
use App\Models\App\Catalogue;
use App\Models\App\Location;
use App\Models\Authentication\Route;
use Illuminate\Http\Request;
use App\Http\Requests\JobBoard\Offer\IndexOfferRequest;
use App\Http\Requests\JobBoard\Offer\StoreOfferRequest;
use App\Http\Requests\JobBoard\Offer\UpdateOfferRequest; 
use App\Http\Requests\JobBoard\Offer\UpdateStatusOfferRequest;
use App\Http\Requests\JobBoard\Offer\DeleteOfferRequest;
use App\Http\Requests\JobBoard\Offer\GetProfessionalOfferRequest;
use Illuminate\Database\Eloquent\Model;

class OfferController extends Controller
{
    function index(IndexOfferRequest $request)
    {
        $company = $request->user()->company()->first();

        if ($request->has('search')) {
            $offers = $company->offers()
                ->aditionalInformation($request->input('search'))
                ->code($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $offers = $company->offers()->paginate($request->input('per_page'));
        }

        if ($offers->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Ofertas',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($offers, 200);
    }

    function store(StoreOfferRequest $request)
    {
        $company = $request->user()->company->first();
        $location = Location::getInstance($request->input('offer.location.id'));
        $contractType = Catalogue::getInstance($request->input('offer.contract_type.id'));
        $position = Catalogue::getInstance($request->input('offer.position.id'));
        $sector = Catalogue::getInstance($request->input('offer.sector.id'));
        $workingDay = Catalogue::getInstance($request->input('offer.working_day.id'));
        $experienceTime = Catalogue::getInstance($request->input('offer.experience_time.id'));
        $trainingHours = Catalogue::getInstance($request->input('offer.training_hours.id'));
        $status = Status::getInstance($request->input('offer.status.id'));
        $lastOffer = Offer::get()->last();
        $number = $lastOffer?$lastOffer->id + 1:1;

        $offer = new Offer;
        $offer->code = $company->prefix.$number;
        $offer->contact_name = $request->input('offer.contact_name');
        $offer->contact_email = $request->input('offer.contact_email');
        $offer->contact_phone = $request->input('offer.contact_phone');
        $offer->contact_cellphone = $request->input('offer.contact_cellphone');
        $offer->remuneration = $request->input('offer.remuneration');
        $offer->vacancies = $request->input('offer.vacancies');
        $offer->start_date = $request->input('offer.start_date');
        $offer->end_date = $this->calculateEndOffer($request->input('offer.start_date'));
        $offer->activities = $request->input('offer.activities');
        $offer->requirements = $request->input('offer.requirements');
        $offer->company()->associate($company);
        $offer->location()->associate($location);
        $offer->contractType()->associate($contractType);
        $offer->position()->associate($position);
        $offer->sector()->associate($sector);
        $offer->workingDay()->associate($workingDay);
        $offer->experienceTime()->associate($experienceTime);
        $offer->trainingHours()->associate($trainingHours);
        $offer->status()->associate($status);

        DB::transaction(function () use($offer, $request) {
            $offer->save();
            $offer->categories()->attach($request->input('offer.categories'));
        });
        

        return response()->json([
            'data' => $offer->refresh(),
            'msg' => [
                'summary' => 'Oferta creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    function show(Offer $offer)
    {
        return response()->json([
            'data' => $offer,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    function getProfessionals(GetProfessionalOfferRequest $request, Offer $offer)
    {
        $professionals = $offer->professionals()->paginate($request->input('per_page'));;
        return response()->json($professionals, 200);
    }

    function update(UpdateOfferRequest $request, Offer $offer)
    {
        $location = Location::getInstance($request->input('offer.location.id'));
        $contractType = Catalogue::getInstance($request->input('offer.contract_type.id'));
        $position = Catalogue::getInstance($request->input('offer.position.id'));
        $sector = Catalogue::getInstance($request->input('offer.sector.id'));
        $workingDay = Catalogue::getInstance($request->input('offer.working_day.id'));
        $experienceTime = Catalogue::getInstance($request->input('offer.experience_time.id'));
        $trainingHours = Catalogue::getInstance($request->input('offer.training_hours.id'));
        $status = Status::getInstance($request->input('offer.status.id'));

        $offer->contact_name = $request->input('offer.contact_name');
        $offer->contact_email = $request->input('offer.contact_email');
        $offer->contact_phone = $request->input('offer.contact_phone');
        $offer->contact_cellphone = $request->input('offer.contact_cellphone');
        $offer->remuneration = $request->input('offer.remuneration');
        $offer->vacancies = $request->input('offer.vacancies');
        $offer->start_date = $request->input('offer.start_date');
        $offer->end_date = $this->calculateEndOffer($request->input('offer.start_date'));
        $offer->activities = $request->input('offer.activities');
        $offer->requirements = $request->input('offer.requirements');
        $offer->location()->associate($location);
        $offer->contractType()->associate($contractType);
        $offer->position()->associate($position);
        $offer->sector()->associate($sector);
        $offer->workingDay()->associate($workingDay);
        $offer->workingDay()->associate($workingDay);
        $offer->experienceTime()->associate($experienceTime);
        $offer->trainingHours()->associate($trainingHours);
        $offer->status()->associate($status);

        DB::transaction(function () use($offer, $request) {
            $offer->categories()->detach();
            $offer->save();
            $offer->categories()->attach($request->input('offer.categories'));
        });

        return response()->json([
            'data' => $offer->refresh(),
            'msg' => [
                'summary' => 'Oferta actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function delete(DeleteOfferRequest $request)
    {
        Offer::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Oferta eliminadas',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }

    function changeStatus(UpdateStatusOfferRequest $request, Offer $offer){
        $offer->status()->associate(Status::find($request->input('offer.status.id')));        
        $offer->save();
        return response()->json([
            'data' => $offer,
            'msg' => [
                'summary' => 'Estado cambio',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function getStatus(Request $request){
        $route = Route::where('uri',$request->input('uri'))->first();
        $status = $route->status()->get();
        return response()->json([
            'data' => $status,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 201);
    }

    private function calculateEndOffer($startDate){
        return (Carbon::createFromFormat('Y-m-d', $startDate))->addMonth();
    }    
}
