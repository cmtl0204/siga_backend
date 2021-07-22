<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;
use App\Models\App\Status;

use App\Http\Requests\Cecy\DetailsPlanification\IndexDetailsPlanificationRequest;
use App\Http\Requests\Cecy\DetailsPlanification\UpdateDetailsPlanificationRequest;
use App\Http\Requests\Cecy\DetailsPlanification\DeleteDetailsPlanificationRequest;
use App\Http\Requests\Cecy\DetailsPlanification\StoreDetailsPlanificationRequest;


class DetailPlanificationController extends Controller
{
    public function index(IndexDetailsPlanificationRequest $request)
    {
        $detailPlanification = DetailPlanification::get();

        return response()->json([
            'data' => $detailPlanification,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }
    public function store(Request $request)
    {
        $data = $request->all();
       $detailPlanifications = $data ['detailPlanification']['detailPlanification'];
       $detailPlanification = new DetailPlanification();
       $detailPlanification -> date_start = $request ->input('detailPlanification.date_start');
       $detailPlanification -> date_end = $request ->input('detailPlanification.date_end');
       $detailPlanification -> summary = $request ->input('detailPlanification.summary');
       $detailPlanification -> planned_end_date = $request ->input('detailPlanification.planned_end_date');
       $detailPlanification -> location_certificate = $request ->input('detailPlanification.location_certificate');
       $detailPlanification -> capacity = $request ->input('detailPlanification.capacity');
       $detailPlanification -> observation = $request ->input('detailPlanification.observation');
       $detailPlanification -> needs = $request ->input('detailPlanification.needs');
       $detailPlanification -> needs_date= $request ->input('detailPlanification.needs_date');
       $detailPlanification->statusCertificate()->associate(Catalogue::findOrFail($status_certificate["id"]));
       $detailPlanification->status()->associate (Status::findOrFail($status["id"]));
       $detailPlanification->course_id()->associate (Course::findOrFail($course_id["id"]));
       $detailPlanification->save();


        return response()->json([
            'data' => [
                'attributes' => $detailPlanification,
                'type' => 'detailPlanification'
            ]
        ], 201);
    }
    function update(UpdateDetailsPlanificationRequest $request, $id)
    {
     
        $detailPlanification = DetailPlanification::find($id);
        $detailPlanification -> date_start = $request ->input('detailPlanification.date_start');
        $detailPlanification -> date_end = $request ->input('detailPlanification.date_end');
        $detailPlanification -> summary = $request ->input('detailPlanification.summary');
        $detailPlanification -> planned_end_date = $request ->input('detailPlanification.planned_end_date');
        $detailPlanification -> location_certificate = $request ->input('detailPlanification.location_certificate');
        $detailPlanification -> capacity = $request ->input('detailPlanification.capacity');
        $detailPlanification -> observation = $request ->input('detailPlanification.observation');
        $detailPlanification -> needs = $request ->input('detailPlanification.needs');
        $detailPlanification -> needs_date= $request ->input('detailPlanification.needs_date');
        $detailPlanification->statusCertificate()->associate(Catalogue::findOrFail($status_certificate["id"]));
        $detailPlanification->status()->associate (Status::findOrFail($status["id"]));
        $detailPlanification->course_id()->associate (Course::findOrFail($course_id["id"]));
        $detailPlanification->save();
 
        return response()->json([
            'data' => [
                'attributes' => $detailPlanification,
                'type' => 'detailPlanification'
            ]
        ], 201);
    }

    
    function destroy($id)
    {
    DetailPlanification::destroy($id); //borrado logico
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Registro(s) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
    
}
