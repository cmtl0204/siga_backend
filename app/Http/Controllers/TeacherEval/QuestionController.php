<?php

namespace App\Http\Controllers\TeacherEval;
//controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\App\FileController;
use App\Http\Controllers\App\ImageController;
//models
use App\Models\App\Catalogue;
use App\Models\App\Status;
use App\Models\TeacherEval\Question;
use App\Models\TeacherEval\EvaluationType;
//formrRquest
use App\Http\Requests\TeacherEval\Question\IndexQuestionRequest;
use App\Http\Requests\TeacherEval\Question\UpdateQuestionRequest;
use App\Http\Requests\TeacherEval\Question\DeleteQuestionRequest;
use App\Http\Requests\TeacherEval\Question\StoreQuestionRequest;
use App\Http\Requests\App\Image\UpdateImageRequest;
use App\Http\Requests\App\Image\UploadImageRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\Image\IndexImageRequest;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
   /* function index(IndexQuestionRequest $request)
    {
        // Crea una instanacia del modelo Evaluation type para poder insertar en el modelo question.
        $evaluationType = EvaluationType::find($request->input('evaluation_type_id'));

        if ($request->has('search')) {
            $question = $evaluationType->questions()
                ->code($request->input('search'))
                ->name($request->input('search'))
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $question = $evaluationType->questions()->paginate($request->input('per_page'));
        }

        if ($question->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron preguntas',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }

        return response()->json($question, 200);
    }*/
    function index(IndexQuestionRequest  $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo question.
        $evaluationType = EvaluationType::getInstance($request->input('evaluation_type_id'));

        if ($request->has('search')) {
            $question = $evaluationType->questions()
                ->code($request->input('search'))
                ->name($request->input('search'))
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $question = $evaluationType->questions()->paginate($request->input('per_page'));
        }

        if ($question->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Preguntas',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($question, 200);
    }

    function show(Question $question)
    {
        return response()->json([
            'data' => $question,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    function store(StoreQuestionRequest $request)
    {
        // Crea una instanacia del modelo Evaluation type para poder insertar en el modelo question.
        $evaluationType = EvaluationType::find($request->input('question.evaluation_type.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo question.
        $type = Catalogue::find($request->input('question.type.id'));
        //dd(Catalogue::all());
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo question.
        $status = Status::find($request->input('question.status.id'));

        $question = new Question();

        $question->code = $request->input('question.code');
        $question->order = $request->input('question.order');
        $question->name = $request->input('question.name');
        $question->description = $request->input('question.description');
        $question->evaluationType()->associate($evaluationType);
        $question->type()->associate($type);
        $question->status()->associate($status);
        $question->save();

        return response()->json([
            'data' => $question,
            'msg' => [
                'summary' => 'Pregunta creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    function update(UpdateQuestionRequest $request, Question $question)
    {
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo question .
        $type = Catalogue::find($request->input('question.type.id'));
        // Crea una instanacia del modelo Status para poder insertar en el modelo question.
        $status = Status::find($request->input('question.status.id'));



        $question->code = $request->input('question.code');
        $question->order = $request->input('question.order');
        $question->name = $request->input('question.name');
        $question->description = $request->input('question.description');
        $question->type()->associate($type);
        $question->status()->associate($status);
        $question->save();

        return response()->json([
            'data' => $question,
            'msg' => [
                'summary' => 'Pregunta Actualizada',
                'detail' => 'El registro fue Actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    function delete(DeleteQuestionRequest $request)
    {
        // Es una eliminación lógica
        Question::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Pregunta(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]
        ], 201);
    }


    /*function uploadImages(UploadImageRequest $request)
    {
        return (new ImageController())->upload($request, Skill::getInstance($request->input('id')));
    }

    function updateImage(UpdateImageRequest $request, $imageId)
    {
        return (new ImageController())->update($request, $imageId);
    }

    function deleteImage($imageId)
    {
        return (new ImageController())->delete($imageId);
    }

    function indexImage(IndexImageRequest $request)
    {
        return (new FileController())->index($request, Question::getInstance($request->input('id')));
    }

    function ShowImage($fileId)
    {
        return (new FileController())->show($fileId);
    }

    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Question::getInstance($request->input('id')));
    }

    function updateFile(UpdateFileRequest $request, $fileId)
    {
        return (new FileController())->update($request, $fileId);
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Question::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }*/
}
