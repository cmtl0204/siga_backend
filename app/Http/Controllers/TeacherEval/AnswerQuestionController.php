<?php

namespace App\Http\Controllers\TeacherEval;

use App\Http\Controllers\Controller;
use App\Models\App\TeacherEval;
use App\Models\TeacherEval\AnswerQuestion;
use App\Models\TeacherEval\Answer;
use App\Models\TeacherEval\Question;
use App\Http\Requests\TeacherEval\AnswerQuestion\IndexAnswerQuestionRequest;
use App\Http\Requests\TeacherEval\AnswerQuestion\StoreAnswerQuestionRequest;
use App\Http\Requests\TeacherEval\AnswerQuestion\UpdateAnswerQuestionRequest;
use App\Http\Requests\TeacherEval\AnswerQuestion\DeleteAnswerQuestionRequest;


class AnswerQuestionController extends Controller

{

function index(IndexAnswerQuestionRequest $request)

{
    if ($request->has('search')) {
        $answerQuestion = AnswerQuestion::
              answer_id($request->input('search'))
            ->question_id($request->input('search'))
            ->paginate($request->input('per_page'));
    } else {
        $answerQuestion = AnswerQuestion::paginate($request->input('per_page'));
     }


if ($answerQuestion->count() === 0) {
    return response()->json([
        'data' => null,
        'msg' => [
            'summary' => 'No se encontraron Respuestas',
            'detail' => 'Intente de nuevo',
            'code' => '404'
        ]], 404);
}



return response()->json($answerQuestion, 200);
}

    function show(AnswerQuestion $answerQuestion)
    {

        return response()->json([
            'data' => $answerQuestion,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

     function store(StoreAnswerQuestionRequest $request)
    {
        //Crea una instanacia del modelo Answer para poder insertar en el modelo AnswerQuestion.
        $answer= Answer::getInstance($request->input('answerQuestion.answer.id'));

         //Crea una instanacia del modelo Question para poder insertar en el modelo AnswerQuestion.
        $question = Question::getInstance($request->input('answerQuestion.question.id'));

        $answerQuestion = new AnswerQuestion();
        $answerQuestion->answer_id = $request->input('answerQuestion.answer.id');
        $answerQuestion->question_id = $request->input('answerQuestion.question.id');
        $answerQuestion->answer()->associate($answer);
        $answerQuestion->question()->associate($question);
        $answerQuestion->save();

        return response()->json([
            'data' => $answerQuestion,
            'msg' => [
                'summary' => 'Habilidad creada',
                'detail' => 'Id creado correctamente',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateAnswerQuestionRequest $request, AnswerQuestion $answerQuestion)
    {
           //Crea una instanacia del modelo Answer para poder insertar en el modelo AnswerQuestion.
        $answer= Answer::getInstance($request->input('answerQuestion.answer.id'));

        //Crea una instanacia del modelo Question para poder insertar en el modelo AnswerQuestion.
       $question = Question::getInstance($request->input('answerQuestion.question.id'));


             // Valida que exista los Id, si no encuentra el registro en la base devuelve un mensaje de error
             if (!$answerQuestion) {
                return response()->json([
                    'data' => null,
                    'msg' => [
                        'summary' => 'Id no encontrado',
                        'detail' => 'Vuelva a intentar',
                        'code' => '404'
                    ]
                ], 404);
            }
            $answerQuestion->answer_id = $request->input('answerQuestion.answer.id');
            $answerQuestion->question_id = $request->input('answerQuestion.question.id');
            $answerQuestion->answer()->associate($answer);
            $answerQuestion->question()->associate($question);
            $answerQuestion->save();

        return response()->json([
            'data' => $answerQuestion,
            'msg' => [
                'summary' => 'Id actualizada',
                'detail' => 'El id fue actualizado',
                'code' => '201'
            ]], 201);
    }

    /*function destroy(AnswerQuestion $answerQuestion)
    {
        // Es una eliminación lógica
        $answerQuestion->delete();

        return response()->json([
            'data' => $answerQuestion,
            'msg' => [
                'summary' => 'Habilidad eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }*/

    function delete(DeleteAnswerQuestionRequest $request)
    {
        // Es una eliminación lógica
        AnswerQuestion::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Question/Answer(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }


}