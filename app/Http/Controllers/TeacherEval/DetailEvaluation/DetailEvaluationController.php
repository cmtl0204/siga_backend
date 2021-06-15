<?php

namespace App\Http\Controllers\TeacherEval\DetailEvaluation;
 use App\Models\TeacherEval\DetailEvaluation;
 use App\Models\TeacherEval\Evaluation;
 use App\Http\Controllers\Controller;
 use App\Http\Requests\TeacherEval\DetailEvaluation\IndexDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\StoreDetailEvaluationRequest;
use Illuminate\Http\Request;

class DetailEvaluationController extends Controller
{
    public function index(IndexDetailEvaluationRequest $request)
    {

       if ($request->has('search')){
        $evaluation = DetailEvaluation::where([
                                            ['evaluation_id', '=', $request->input('evaluation_id')],
                                            ['result', '=', $request->input('search')]
                                          ])
                                       ->paginate($request->input('per_page'));
       }
       if ($evaluation->count() === 0) {
           return response()->json([
               'data' => null,
               'msg' => [
                'summary' => 'No se encontraron Resultados',
                'detail' => 'Intente de nuevo',
                'code' => '404'
               ]], 404);
       }

     return response()->json($evaluation, 200);
    }

    public function show(DetailEvaluation $detail)
    {

        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

   public function store(StoreDetailEvaluationRequest $request)
    {
        $evaluationResponce = Evaluation::findOrFail($request->input('evaluation.id'));
        $detail = new DetailEvaluation();
        $detail->result = $request->input('detail.result');
        $detail->evaluation_id = $evaluationResponce->id;
        $evaluationResponce->detailEvaluation()->save($detail);

        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }


    public function update(DetailEvaluation $detail, Request $request)
    {
        $evaluationResponce = DetailEvaluation::find($detail->id);

       // $detail->result = $request->input('result');
        $evaluationResponce->fill([ 'result' => $request->input('result') ]);
        $evaluationResponce->save();
        $evaluationResponce->refresh();

        return response()->json([
            'data' => $evaluationResponce,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

   /* public function store(Request $request)
    {


        $detail = new Evaluation();
        $detail->name = $request->input('name');
        $detail->save();


        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }*/
}
