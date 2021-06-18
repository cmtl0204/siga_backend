<?php

namespace App\Http\Controllers\TeacherEval\DetailEvaluation;
 use App\Models\TeacherEval\DetailEvaluation;
 use App\Models\TeacherEval\Evaluation;
 use App\Http\Controllers\Controller;
 use App\Http\Requests\TeacherEval\DetailEvaluation\IndexDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\StoreDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\UpdateDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\DeleteDetailEvaluationRequest;
use Illuminate\Http\Request;

class DetailEvaluationController extends Controller
{
   /* public function index(IndexDetailEvaluationRequest $request)
    {

       if ($request->has('search')){
        $evaluation = DetailEvaluation::where([
                                            ['evaluation_id', '=', $request->input('evaluation_id')],
                                            ['result', '=', $request->input('search')]
                                          ])
                                       ->paginate($request->input('per_page'));
       }
       else {
        $evaluation = DetailEvaluation::where([
            ['evaluation_id', '=', $request->input('evaluation_id')],

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
    }*/


    function index(IndexDetailEvaluationRequest  $request)
{
    // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
    $evaluation = Evaluation::getInstance($request->input('evaluation_id'));

    if ($request->has('search')) {
        $detail = $evaluation->detailEvaluation()
            ->result($request->input('search'))

            ->paginate($request->input('per_page'));
    } else {
        $detail = $evaluation->detailEvaluation()->paginate($request->input('per_page'));
    }

    if ($detail->count() === 0) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraron Habilidades',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);
    }

    return response()->json($detail, 200);
}


   function show(DetailEvaluation $detail)
    {

        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

   function store(StoreDetailEvaluationRequest $request)
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


    function update(Request $request, DetailEvaluation $detail)
    {
        $evaluationResponce = Evaluation::findOrFail($request->input('evaluation.id'));

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


    /*function update(UpdateDetailEvaluationRequest $request, DetailEvaluation $detail  )
    {
        $evaluationResponce = DetailEvaluation::find($detail->id);

       // $detail->result = $request->input('result');
        $evaluationResponce->fill([ 'result' => $request->input('detail.result') ]);
        $evaluationResponce->save();
        $evaluationResponce->refresh();

        return response()->json([
            'data' => $evaluationResponce,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }*/


    function delete(DeleteDetailEvaluationRequest $request)
    {
        // Es una eliminación lógica
        DetailEvaluation::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Habilidad(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }


    /*function destroy(DetailEvaluation $detail)
    {

        $detail->delete();
        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'Eliminado con exito',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }*/

   /* function store(Request $request)
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
