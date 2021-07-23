<?php

namespace App\Http\Controllers\TeacherEval\Evaluation;
 use App\Models\App\Status;
 use App\Models\App\SchoolPeriod;
 use App\Models\App\Teacher;
 use App\Models\TeacherEval\EvaluationType;
 use App\Models\TeacherEval\Evaluation;
 use App\Models\TeacherEval\ExtraCredit;
 use App\Http\Controllers\Controller;
 use App\Http\Requests\TeacherEval\Evaluation\IndexEvaluationRequest;
 use App\Http\Requests\TeacherEval\Evaluation\StoreEvaluationRequest;
 use App\Http\Requests\TeacherEval\Evaluation\UpdateEvaluationRequest;
 use App\Http\Requests\TeacherEval\Evaluation\DeleteEvaluationRequest;
use Illuminate\Http\Request;
//use DB;
use \Illuminate\Support\Facades\DB;

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


    function getGestionAcademicaById(Evaluation $traer, $id)
    {

        $traer = DB::table('teacher_eval.evaluations')
                ->join('app.teachers', 'app.teachers.id', '=', 'teacher_eval.evaluations.teacher_id')
                ->join('teacher_eval.evaluation_types', 'teacher_eval.evaluation_types.id', '=', 'teacher_eval.evaluations.evaluation_type_id' )
                ->join('app.school_periods', 'app.school_periods.id', '=', 'teacher_eval.evaluations.school_period_id' )

                ->leftJoin('teacher_eval.extra_credits', 'app.teachers.id', '=', 'teacher_eval.extra_credits.teacher_id' )
                ->leftJoin('teacher_eval.researchs', 'app.teachers.id', '=', 'teacher_eval.researchs.teacher_id' )
                ->where('teachers.id', '=', $id)
                ->orderBy('evaluation_types.name',  'asc')
                ->orderBy('teachers.name', 'asc')
                ->select('evaluation_types.name', 'extra_credits.total as extraCredits','teachers.id', 'researchs.inv_auto_eval', 'researchs.inv_pares', 'researchs.inv_coodinador', 'researchs.total  as investigation',  'school_periods.name as periodo', 'teachers.name as nameTeacher', 'evaluations.result', DB::raw("round(evaluations.result * evaluation_types.percentage ) as percentage"))

                ->get();

                   return response()->json([
                    'data' => $traer,
                    'msg' => [
                        'summary' => 'success',
                        'detail' => '',
                        'code' => '201'
                    ]], 201);
    }



    /*function getAllEvaluations(Evaluation $traer )
    {

        $traer = DB::table('teacher_eval.evaluations')
                ->join('app.teachers', 'app.teachers.id', '=', 'teacher_eval.evaluations.teacher_id')
                ->join('teacher_eval.evaluation_types', 'teacher_eval.evaluation_types.id', '=', 'teacher_eval.evaluations.evaluation_type_id' )
                /*->join('teacher_eval.extra_credits', 'teacher_eval.extra_credits.id', '=', 'teacher_eval.extra_credits.teacher_id' )*/
              /*  ->orderBy('evaluation_types.name',  'asc')
                ->select('evaluation_types.name ', 'teachers.id',  'evaluations.result', DB::raw("round(evaluations.result * evaluations.percentage ) as percentage"))
                ->select('teachers.name as nameTeacher')

                ->get();

                   return response()->json([
                    'data' => $traer,
                    'msg' => [
                        'summary' => 'success',
                        'detail' => '',
                        'code' => '201'
                    ]], 201);
    }*/


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
    function saveTeacher(Request $request, $id )
    {
        //$schoolPeriod = SchoolPeriod::findOrFail($request->input('shoolPeriod.id'));
        $teacher = Teacher::getInstance($id);
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


    function getEt(Request $request ){
        $teacher = EvaluationType::all();
        return response()->json([
            'data' => $teacher,
            'msg' => [
                'summary' => 'success'
            ]
            ], 200);
    }

    function deleteT(Request $request)
    {
        // Es una eliminación lógica
        Teacher::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Habilidad(es) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }


}
