<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Subject\IndexSubjectRequest;
use App\Models\App\Subject;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(IndexSubjectRequest $request)
    {

        // get all the Subjects
        $subjects = Subject::all();

        return response()->json(['data' => $subjects, 'msg' => [
            'summary' => 'success',
            'detail' => 'La búsqueda se realizo con éxito',
            'code' => '200'
        ]], 200);
    }
}
