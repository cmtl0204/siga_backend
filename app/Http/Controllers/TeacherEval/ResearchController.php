<?php

namespace App\Http\Controllers\TeacherEval;
 use App\Models\TeacherEval\DetailEvaluation;
 use App\Models\TeacherEval\Evaluation;
 use App\Models\TeacherEval\ExtraCredit;
 use App\Models\TeacherEval\Research;
 use App\Models\App\Teacher;
 use App\Http\Controllers\Controller;
 use App\Http\Requests\TeacherEval\DetailEvaluation\IndexDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\StoreDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\UpdateDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\DeleteDetailEvaluationRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;

class ResearchController extends Controller
{



    /*function index(Request  $request)
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
}*/
        function getAll(Research $request ){
            $detail = Research::all();
            return response()->json([
                'data' => $detail,
                'msg' => [
                    'summary' => 'success'
                ]
                ], 200);
        }


        function getInvestigacion(Research $extra){

            $traer = DB::table('teacher_eval.researchs')
            ->join('app.teachers', 'app.teachers.id', '=', 'teacher_eval.researchs.teacher_id' )
            ->orderBy('teachers.name', 'asc')
            ->select('teacher_eval.researchs.inv_auto_eval', 'teacher_eval.researchs.inv_pares', 'teacher_eval.researchs.inv_coodinador', 'teacher_eval.researchs.total', 'teacher_eval.researchs.total', 'teacher_eval.researchs.id as id', 'teachers.name' )


            ->get();

               return response()->json([
                'data' => $traer,
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '201'
                ]], 201);

        }

   function show(Research $extra)
    {

        return response()->json([
            'data' => $extra,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }


   function store(Request $request, $id)
    {
        $teacher = Teacher::getInstance($id);
        $detail = new Research();
        $detail->inv_auto_eval = $request->input('research.inv_auto_eval');
        $detail->inv_pares = $request->input('research.inv_pares');
        $detail->inv_coodinador = $request->input('research.inv_coodinador');
        $detail->total = $request->input('research.total');
        $detail->teacher()->associate($teacher);
        $detail->save();

        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }


    function update(Request $request, Research $detail)
    {
        $teacher = Teacher::getInstance($request->input('teacher.id'));
        $detail->inv_auto_eval = $request->input('research.inv_auto_eval');
        $detail->inv_pares = $request->input('research.inv_pares');
        $detail->inv_coodinador = $request->input('research.inv_coodinador');
        $detail->total = $request->input('research.total');
        $detail->teacher()->associate($teacher);
        $detail->save();

        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }





    /*function delete(Request $request)
    {
        // Es una eliminación lógica
        Research::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Habilidad(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }*/


    function delete(Request $request, $id)
    {
        // Es una eliminación lógica
        $request = Research::find($id);
        $request->delete();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Habilidad(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }





}
