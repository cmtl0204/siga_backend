<?php

namespace App\Http\Controllers\Uic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uic\Tutor\DeleteTutorRequest;
use App\Http\Requests\Uic\Tutor\IndexTutorRequest;
use App\Http\Requests\Uic\Tutor\StoreTutorRequest;
use App\Http\Requests\Uic\Tutor\UpdateTutorRequest;
use App\Models\Uic\Tutor;
// Models

// FormRequest en el index store update

class TutorController extends Controller
{
    public function index(IndexTutorRequest $request)
    {
        if ($request->has('per_page')) {
            $tutor = Tutor::paginate($request->input('per_page'));
        } else {
            $tutor = Tutor::project()->get();
        }

        if ($tutor->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron tutores',
                    'detail' => 'Intentelo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($tutor, 200);
    }

    public function show(Tutor $tutor)
    {
        if (!$tutor) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El tutor no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json([
            'data' => $tutor,
            'msg' => [
                'summary' => '',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    public function store(StoreTutorRequest $request)
    {
        $tutor = new Tutor;
        $tutor->project_plan_id = $request->input('tutor.project_plan.id');
        $tutor->teacher_id = $request->input('tutor.teacher.id');
        $tutor->type_id = $request->input('tutor.type.id');
        $tutor->observations = $request->input('tutor.observations');
        $tutor->save();
        return response()->json([
            'data' => $tutor->fresh(),
            'msg' => [
                'summary' => 'Tutor creado',
                'detail' => 'El tutor fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    public function update(UpdateTutorRequest $request, $id)
    {
        $tutor = Tutor::find($id);
        if (!$tutor) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El tutor no existe',
                    'detail' => 'Intente otra vez',
                    'code' => '404'
                ]
            ], 400);
        }
        $tutor->project_plan_id = $request->input('tutor.project_plan.id');
        $tutor->teacher_id = $request->input('tutor.teacher.id');
        $tutor->type_id = $request->input('tutor.type.id');
        $tutor->observations = $request->input('tutor.observations');
        $tutor->save();
        return response()->json([
            'data' => $tutor->fresh(),
            'msg' => [
                'summary' => 'Tutor actualizado',
                'detail' => 'El tutor fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }
    function delete(DeleteTutorRequest $request)
    {
        // Es una eliminación lógica
        Tutor::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Tutor(es) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }
}
