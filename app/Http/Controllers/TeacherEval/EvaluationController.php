<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Evaluation;

use Illuminate\Http\Request;

class EvaluationController extends Controller 
{
    public function index (Request $request)
    {
        if ($request-> has('parent_it')) {
            $parent = Evaluation:: firtsWhere('parent_id', $request->pa)
        }
    }
}