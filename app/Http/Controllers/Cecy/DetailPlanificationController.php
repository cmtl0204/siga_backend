<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cecy\DetailPlanification;

use App\Http\Requests\Cecy\DetailsPlanifications\IndexDetailsPlanificationRequest;


class DetailPlanificationController extends Controller
{
    public function index(IndexDetailsPlanificarioneRequest $request)
    {
        $detailPlanification = DetailPlanification::all();

        return response()->json([
            'data' => $detailPlanification,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }
    
}
