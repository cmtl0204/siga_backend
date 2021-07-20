<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\MeshStudent\IndexMeshStudentRequest;
use App\Models\App\MeshStudent;

// Models

// FormRequest en el index store update

class MeshStudentController extends Controller
{
    public function index(IndexMeshStudentRequest $request)
    {
        if ($request->has('per_page')) {
            $student = MeshStudent::with('meshStudentRequirements')->paginate($request->input('per_page'));
        } else {
            $student = MeshStudent::with('meshStudentRequirements')->get();
        }

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
