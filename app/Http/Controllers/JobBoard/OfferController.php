<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\JobBoard\Company;
use App\Models\JobBoard\Offer;
use App\Models\App\Status;
use App\Models\App\Catalogue;
use App\Models\App\Location;
use App\Http\Requests\JobBoard\Offer\IndexOfferRequest;
use App\Http\Requests\JobBoard\Offer\CreateOfferRequest;
use App\Http\Requests\JobBoard\Offer\UpdateOfferRequest;
use Illuminate\Database\Eloquent\Model;

class OfferController extends Controller
{
    function index(IndexOfferRequest $request)
    {
        $company = Company::getInstance($request->input('company_id'));

        if ($request->has('search')) {
            $offer = $company->offers()
                ->aditional_information($request->input('search'))
                ->code($request->input('search'))
                ->description($request->input('search'))
                ->get();
        } else {
            $offer = $company->offers()->paginate($request->input('per_page'));
        }

        if (sizeof($offer) === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Ofertas',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($offer, 200);
    }

    function store(CreateOfferRequest $request)
    {
        $company = Company::getInstance($request->input('company.id'));
        $location = Location::getInstance($request->input('location.id'));
        $contractType = Catalogue::getInstance($request->input('contractType.id'));
        $position = Catalogue::getInstance($request->input('position.id'));
        $sector = Catalogue::getInstance($request->input('sector.id'));
        $workingDay = Catalogue::getInstance($request->input('workingDay.id'));
        $experienceTime = Catalogue::getInstance($request->input('experienceTime.id'));
        $trainingHours = Catalogue::getInstance($request->input('trainingHours.id'));
        $status = Status::getInstance($request->input('status.id'));

        //$lastOffer = Offer::orderBy('id', 'desc')->first();

        $offer = new Offer();
        //$offer->code = $lastOffer ? ($lastOffer->code + 1) : 1;
        $offer->code = $request->input('offer.code');
        $offer->description = $request->input('offer.description');
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
        $offer->save();

        foreach ($request->input('categories') as $category) {
            $offer->categories()->attach($category);
        }

        return response()->json([
            'data' => $offer,
            'msg' => [
                'summary' => 'Oferta creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    function show($offerId)
    {
        if (!is_numeric($offerId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        $offer = Offer::find($offerId);

        if (!$offer) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Oferta no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }
        return response()->json([
            'data' => $offer,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    function update(UpdateOfferRequest $request, $offerId)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $offer = Offer::find($offerId);
        $offer->status()->associate(Status::firstWhere('code', $catalogues['status']['paused']));
        $offer->save();

        $location = Location::getInstance($request->input('location.id'));
        $contractType = Catalogue::getInstance($request->input('contractType.id'));
        $position = Catalogue::getInstance($request->input('position.id'));
        $sector = Catalogue::getInstance($request->input('sector.id'));
        $workingDay = Catalogue::getInstance($request->input('workingDay.id'));
        $experienceTime = Catalogue::getInstance($request->input('experienceTime.id'));
        $trainingHours = Catalogue::getInstance($request->input('trainingHours.id'));
        $status = Status::getInstance($request->input('status.id'));

        $offer = Offer::find($offerId);

        if (!$offer) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Oferta no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $offer->code = $request->input('offer.code');
        $offer->description = $request->input('offer.description');
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

        $offer->save();

        return response()->json([
            'data' => $offer,
            'msg' => [
                'summary' => 'Oferta actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function destroy($offerId)
    {
        if (!is_numeric($offerId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        $offer = Offer::find($offerId);

        if (!$offer) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Oferta no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $offer->delete();

        return response()->json([
            'data' => $offer,
            'msg' => [
                'summary' => 'Oferta eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }

    function getProfessionals(){
        return $offer->professionals()->get();
    }

    private function calculateEndOffer($startDate){
        return (Carbon::createFromFormat('Y-m-d', $startDate))->addMonth();
    }
}