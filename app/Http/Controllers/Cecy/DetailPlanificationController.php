<?php

namespace App\Http\Controllers\Cecy;

// Controllers
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\DetailPlanification\IndexDetailPlanificationRequest;

use App\Models\Cecy\Planification;
use App\Models\Cecy\DetailPlanification;
use App\Models\Authentication\User;
use App\Models\App\Catalogue;




//Form Request


class DetailPlanificationController extends Controller
{
    //Recuperacion de todos los registros o solo de uno
    function index(IndexDetailPlanificationRequest $request){
      $detailPlanification = DetailPlanification::with('course')->get();

        return response()->json([
            'data' => $detailPlanification,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);

            // if($request->has('search')){
            //     $planification = $planification
            // }
    }

    // obtener un único objeto o registro
    function show(DetailPlanification $detailPlanification){
      return response()->json([
        'data' => $detailPlanification::with('course')->first(),
        'msg' => [
            'summary' => 'success',
            'detail' => '',
            'code'=> '200'
        ]], 200);
    }
}
