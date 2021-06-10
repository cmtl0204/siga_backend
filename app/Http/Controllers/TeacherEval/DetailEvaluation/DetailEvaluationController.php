<?php

namespace App\Http\Controllers\TeacherEval\DetailEvaluation;
 use App\Models\TeacherEval\DetailEvaluation;
 use App\Http\Controllers\Controller;
 use App\Http\Requests\TeacherEval\DetailEvaluation\IndexDetailEvaluationFormRequest;
use Illuminate\Http\Request;

class DetailEvaluationController extends Controller
{
    public function index(IndexDetailEvaluationFormRequest $request)
    {
       /* $detail = DetailEvaluation::getInstance($reques->input('evaluation_id'));*/

       $detail = DetailEvaluation::all();
       return response()->json([
        'data' = $detail,
        'msg' => 'Hola'], 200);
    }

    public function show(DetailEvaluation $detail)
    {

        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function store(Request $request)
    {
        $detail = new DetailEvaluation();
        $detail->result = $request->input('result');
        $detail->save();

        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }
}
