<?php

namespace App\Http\Controllers\TeacherEval;

use App\Http\Controllers\Controller;
use App\Models\App\Evaluation;
use App\Models\TeacherEval\EvaluationType;
use App\Models\TeacherEval\Teacher;
use App\Models\TeacherEval\SchoolPeriod;
use App\Models\TeacherEval\Status;
use App\Http\Requests\TeacherEval\TeacherEvaluationRequest;

use Illuminate\Http\Request;

class EvaluationController extends Controller 
{
    public function index (TeacherEvaluationRequest $request){
        /**$evaluation = EvaluationType ::getInstance($request->input('evaluation_type_id'));
    
        $teacher = Teacher ::getInstance($request->input('teacher_id'));

        $schoolPeriod = SchoolPeriod ::getInstamce($request->input('school_period_id'));

        $status = Status ::getInstance($request->input('status_id'));

        if ($request ) {
            # code...
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
    **/
    }
}