<?php

namespace App\Http\Controllers\Authentication;
/*use Dyrynda\Database\Support\CascadeSoftDeletes;
use CascadeSoftDeletes;
 protected $cascadeDeletes = ['files'];*/
 use App\Models\TeacherEval\DetailEvaluation;
use Illuminate\Http\Request;

class DetailEvaluationController extends Controller
{
    public function index()
    {
        // nombre, modalidad,
        return response()->json(DetailEvaluation::all(), 200);
    }

    //public
}
