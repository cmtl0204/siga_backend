<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Student\IndexStudentRequest;
use App\Http\Requests\Uic\Student\StoreStudentRequest;
use App\Http\Requests\Uic\Student\UpdateStudentRequest;
use App\Models\Uic\Student;

// Models

// FormRequest en el index store update

class StudentController extends Controller
{
    public function index(IndexStudentRequest $request)
    {
        if ($request->has('per_page')) {
            $student = Student::paginate($request->input('per_page'));
        } else {
            $student = Student::project()->get();
        }


        return response()->json($student, 200);
    }

    public function show(Student $student) //cambiar
    {
        if (!$student) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El estudiante no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $student,
            'msg' => [
                'summary' => '',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = new Student;
        $student->project_plan_id = $request->input('student.project_plan.id');
        $student->mesh_student_id = $request->input('student.mesh_student.id');
        $student->observations = $request->input('student.observations');
        $student->save();
        return response()->json([
            'data' => $student->fresh(),
            'msg' => [
                'summary' => 'estudiante creado',
                'detail' => 'El estudiante fue creado',
                'code' => '201'
            ]
        ], 201);

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encuentra el estudiante',
                'detail' => 'Intente otra vez',
                'code' => '404'
            ]
        ], 404);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        if (!$student) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El estudiante no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 400);
        }
        $student->project_plan_id = $request->input('student.project_plan.id');
        $student->mesh_student_id = $request->input('student.mesh_student.id');
        $student->observations = $request->input('student.observations');
        $student->save();
        return response()->json([
            'data' => $student->fresh(),
            'msg' => [
                'summary' => 'Estudiante actualizado',
                'detail' => 'El estudiante fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }
}
