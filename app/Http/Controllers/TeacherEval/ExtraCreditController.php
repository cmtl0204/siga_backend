<?php

namespace App\Http\Controllers\TeacherEval;
 use App\Models\TeacherEval\DetailEvaluation;
 use App\Models\TeacherEval\Evaluation;
 use App\Models\TeacherEval\ExtraCredit;
 use App\Models\App\Teacher;
 use App\Http\Controllers\Controller;
 use App\Http\Requests\TeacherEval\DetailEvaluation\IndexDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\StoreDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\UpdateDetailEvaluationRequest;
 use App\Http\Requests\TeacherEval\DetailEvaluation\DeleteDetailEvaluationRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;

class ExtraCreditController extends Controller
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
        function getAll(Request $request ){
            $detail = ExtraCredit::all();
            return response()->json([
                'data' => $detail,
                'msg' => [
                    'summary' => 'success'
                ]
                ], 200);
        }


   function show(ExtraCredit $id)
    {

        return response()->json([
            'data' => $id,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }


    function getExtraCredit(ExtraCredit $extra){

        $traer = DB::table('teacher_eval.extra_credits')
        ->join('app.teachers', 'app.teachers.id', '=', 'teacher_eval.extra_credits.teacher_id' )
        ->orderBy('teachers.name', 'asc')
        ->select('teacher_eval.extra_credits.diploma_yavirac', 'teacher_eval.extra_credits.title_fourth_level', 'teacher_eval.extra_credits.OCS_member', 'teacher_eval.extra_credits.governing_processes', 'teacher_eval.extra_credits.process_nouns', 'teacher_eval.extra_credits.support_processes', 'teacher_eval.extra_credits.total', 'teacher_eval.extra_credits.id as id', 'teachers.name' )


        ->get();

           return response()->json([
            'data' => $traer,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);

    }


   function store(Request $request, $id)
    {
        $teacher = Teacher::getInstance($id);
        $detail = new ExtraCredit();
        $detail->diploma_yavirac = $request->input('credit.diploma_yavirac');
        $detail->title_fourth_level = $request->input('credit.title_fourth_level');
        $detail->OCS_member = $request->input('credit.OCS_member');
        $detail->governing_processes = $request->input('credit.governing_processes');
        $detail->process_nouns = $request->input('credit.process_nouns');
        $detail->support_processes = $request->input('credit.support_processes');
        $detail->total = $request->input('credit.total');
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


   /* function update(Request $request, ExtraCredit $detail)
    {
        $teacher = Teacher::getInstance($request->input('teacher.id'));

        $detail->diploma_yavirac = $request->input('credit.diploma_yavirac');
        $detail->title_fourth_level = $request->input('credit.title_fourth_level');
        $detail->OCS_member = $request->input('credit.OCS_member');
        $detail->governing_processes = $request->input('credit.governing_processes');
        $detail->process_nouns = $request->input('credit.process_nouns');
        $detail->support_processes = $request->input('credit.support_processes');
        $detail->total = $request->input('credit.total');
        $detail->teacher()->associate($teacher);
        $detail->save();

        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }*/

    function update (Request $request, ExtraCredit $detail, $id)
    {
        $detail = ExtraCredit::find($id);
        if(is_null($detail)){
            return response()->json(['message' => 'Credito Extra no encontrado '], 404);
        }
        $detail->update($request->all());

        return response()->json(
            $detail, 200

        );

    }




  /*  function delete(Request $request)
    {
        // Es una eliminación lógica
        ExtraCredit::destroy($request->input('ids'));

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
        $request = ExtraCredit::find($id);
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
