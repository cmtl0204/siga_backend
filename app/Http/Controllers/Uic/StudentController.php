<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Student\IndexStudentRequest;
use App\Models\Uic\Student;

// Models

// FormRequest en el index store update

class StudentController extends Controller
{
    public function index(IndexStudentRequest $request)
    {

        $student = Student::paginate($request->input('per_page'));

        if ($student->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron estudiantes',
                    'detail' => 'Intentelo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($student, 200);
    }
}
