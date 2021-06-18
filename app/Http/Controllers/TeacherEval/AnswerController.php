<?php

namespace App\Http\Controllers\TeacherEval;

use App\Http\Controllers\Controller;
use App\Models\App\TeacherEval;
use App\Models\App\Status;
use App\Models\App\AnswerQuestion;
use App\Models\TeacherEval\Answer;
use App\Http\Requests\TeacherEval\Answer\StoreAnswerRequest;
use App\Http\Requests\TeacherEval\Answer\IndexAnswerRequest;
use App\Http\Requests\TeacherEval\Answer\UpdateAnswerRequest;
use App\Http\Requests\TeacherEval\Answer\DeleteAnswerRequest;


class AnswerController extends Controller
{
        function index(IndexAnswerRequest $request)
        {
            // Crea una instanacia del modelo Status para poder insertar en el modelo answer.
            $status = Status::getInstance($request->input('status_id'));
        
            if ($request->has('search')) {
                $answer = $status->answers()
                    ->code($request->input('search'))
                    ->name($request->input('search'))
                    ->paginate($request->input('per_page'));
            } else {
                $answer = $status->answers()->paginate($request->input('per_page'));
            }
        
    if ($answer->count() === 0) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraron Respuestas',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);
    }

    return response()->json($answer, 200);
}

    function show(Answer $answer)

    {
        return response()->json([
            'data' => $answer,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    function store(StoreAnswerRequest $request )

    {
        
          // Crea una instanacia del modelo Status para poder insertar en el modelo answer
        $status = Status::getInstance($request->input('status.id'));
        $answer = new Answer();
        $answer->code = $request->input('answer.code');
        $answer->order = $request->input('answer.order');
        $answer->name = $request->input('answer.name');
        $answer->value = $request->input('answer.value');
        $answer->status()->associate($status);
        $answer->save();

        return response()->json([
            'data' => $answer,
            'msg' => [
                'summary' => 'Respuesta creada',
                'detail' => 'La respuesta fue creada exitosamente',
                'code' => '201'
            ]], 201);
    }
 
    // actualiza los campos de Answer
    function update(UpdateAnswerRequest $request, Answer $answer)

    {
          // Crea una instanacia del modelo Status para poder insertar en el modelo answer
        $status = Status::getInstance ($request->input('status.id'));
        $answer->code = $request->input('answer.code');
        $answer->order = $request->input('answer.order');
        $answer->name = $request->input('answer.name');
        $answer->value = $request->input('answer.value');
        $answer->status()->associate($status);
        $answer->save();

        return response()->json([
            'data' => $answer,
            'msg' => [
                'summary' => 'Respuesta actualizada',
                'detail' => 'La respuesta fue actualizada correctamente',
                'code' => '201'
            ]], 201);
    }

  /*  function destroy(Answer $answer)
    {
        // Es una eliminación lógica
        $answer->delete();

        return response()->json([
            'data' => $answer,
            'msg' => [
                'summary' => 'Respuesta eliminada',
                'detail' => 'Repuesta eliminada correctamente',
                'code' => '201'
            ]], 201);
    } */

    function delete(DeleteAnswerRequest $request )
    
    {
        // Es una eliminación lógica
        Answer::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Answer(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }

}
