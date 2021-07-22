<?php

namespace App\Http\Controllers\TeacherEval\Evaluation;
 use App\Models\App\Status;
 use App\Models\App\SchoolPeriod;
 use App\Models\App\Teacher;
 use App\Models\TeacherEval\EvaluationType;
 use App\Models\TeacherEval\Evaluation;
 use App\Http\Controllers\Controller;
 use App\Http\Requests\TeacherEval\Evaluation\IndexEvaluationRequest;
 use App\Http\Requests\TeacherEval\Evaluation\StoreEvaluationRequest;
 use App\Http\Requests\TeacherEval\Evaluation\UpdateEvaluationRequest;
 use App\Http\Requests\TeacherEval\Evaluation\DeleteEvaluationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
   /* function index(IndexDetailEvaluationRequest $request)
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


   function index(IndexEvaluationRequest  $request)
{
    // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
    $evaluation = Teacher::getInstance($request->input('teacher_id'));

    if ($request->has('search')) {
        $detail = $evaluation->evaluation()
            ->result($request->input('search'))
            //->percentage($request->input('search'))
            ->paginate($request->input('per_page'));
    } else {
        $detail = $evaluation->evaluation()->paginate($request->input('per_page'));
    }

    if ($detail->count() === 0) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraron Resultados',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);
    }

    return response()->json($detail, 200);
}


     function show(Evaluation $evaluation)
    {

        return response()->json([
            'data' => $evaluation,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }



    function getGestionAcademica(Evaluation $evaluation)
    {

        $teacher = DB::table('teacher_eval.evaluations')
                   ->leftJoin('app.teachers',  'app.teachers.id',  '=', 'teacher_eval.evaluations.teacher_id')
                   ->leftJoin('teacher_eval.evaluation_types', 'teacher_eval.evaluation_types.id', '=', 'teacher_eval.evaluations.evaluation_type_id' )
                   ->select('teachers.id', 'evaluations.result', 'evaluation_types.name' )
                   ->where('evaluation_types.name', '=', 'Gestion Academica')
                   ->orderBy('teachers.name', 'asc')
                   ->get();
                   return response()->json([
                    'data' => $teacher,
                    'msg' => [
                        'summary' => 'success',
                        'detail' => '',
                        'code' => '201'
                    ]], 201);
    }




    function store(StoreEvaluationRequest $request)
    {
        //$schoolPeriod = SchoolPeriod::findOrFail($request->input('shoolPeriod.id'));
        $teacher = Teacher::getInstance($request->input('teacher.id'));
        $evaluationType = EvaluationType::getInstance($request->input('evaluation_type.id'));
        $schoolPeriod = SchoolPeriod::getInstance($request->input('shoolPeriod.id'));
        $status = Status::getInstance($request->input('status.id'));
        $detail = new Evaluation();
        $detail->result = $request->input('evaluation.result');
        $detail->percentage = $request->input('evaluation.percentage');
        $detail->teacher()->associate($teacher);
        $detail->evaluationType()->associate($evaluationType);
        $detail->schoolPeriod()->associate($schoolPeriod);
        $detail->status()->associate($status);
        $detail->save();
        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }


     function update(UpdateEvaluationRequest $request, Evaluation $detail  )
    {
        $teacher = Teacher::getInstance($request->input('teacher.id'));
        $evaluationType = EvaluationType::getInstance($request->input('evaluation_type.id'));
        $schoolPeriod = SchoolPeriod::getInstance($request->input('shoolPeriod.id'));
        $status = Status::getInstance($request->input('status.id'));
        $detail->result = $request->input('evaluation.result');
        $detail->percentage = $request->input('evaluation.percentage');
        $detail->teacher()->associate($teacher);
        $detail->evaluationType()->associate($evaluationType);
        $detail->schoolPeriod()->associate($schoolPeriod);
        $detail->status()->associate($status);
        $detail->save();
        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }


    function delete(DeleteEvaluationRequest $request)
    {
        // Es una eliminación lógica
        Evaluation::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Habilidad(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }


   /* function destroy(DetailEvaluation $detail)
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


    /* ---------------- Funciones de Ayuda  ----------------------------  */

   public function school(Request $request)

    {


        $detail = new SchoolPeriod();
        $detail->name = $request->input('name');
        $detail->start_date = $request->input('start_date');

        $detail->save();


        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }

    public function profe(Request $request)

    {


        $detail = new Teacher();
        $detail->name = $request->input('name');


        $detail->save();


        return response()->json([
            'data' => $detail,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '201'
            ]], 201);
    }


    function getall(Request $request ){
        $evaluation = Evaluation::all();
        return response()->json([
            'data' => $evaluation,
            'msg' => [
                'summary' => 'success'
            ]
            ], 200);
    }

    function getTeachers(Request $request ){
        $teacher = Teacher::all();
        return response()->json([
            'data' => $teacher,
            'msg' => [
                'summary' => 'success'
            ]
            ], 200);
    }

}
