<?php

namespace App\Http\Controllers\TeacherEval;
//controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\App\FileController;
use App\Http\Controllers\App\ImageController;
//models
use App\Models\App\Catalogue;
use App\Models\TeacherEval\Question;
//formrRquest
use App\Http\Requests\TeacherEval\EvaluationType\IndexEvaluationTypeRequest;
use App\Http\Requests\TeacherEval\EvaluationType\UpdateEvaluationTypeRequest;
use App\Http\Requests\TeacherEval\EvaluationType\DeleteEvaluationTypeRequest;
use App\Http\Requests\TeacherEval\EvaluationType\StoreEvaluationTypeRequest;
use App\Http\Requests\App\Image\UpdateImageRequest;
use App\Http\Requests\App\Image\UploadImageRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\Image\IndexImageRequest;


class EvaluationTypeController extends Controller
{
    function index(IndexEvaluationTypeRequest $request)
{
    return response()->json([
        'data' => $evaluationType,
        'msg' => [
            'summary' => 'success',
            'detail' => '',
            'code' => '200'
        ]], 200);
    // Crea una instanacia del modelo Evaluation types para poder insertar en el modelo question.
/*     $evaluationType = EvaluationType::getInstance($request->input('evaluation_type_id'));

    if ($request->has('search')) {
        $evaluationType = $evaluationType->evaluationTypes()
            ->code($request->input('search'))
            ->name($request->input('search'))
            ->percentage($request->input('search'))
            ->global_percentage($request->input('search'))
            ->paginate($request->input('per_page'));
    } else {
        $evaluationType = $evaluationType->evaluationTypes()->paginate($request->input('per_page'));
    }

    if ($evaluationType->count() === 0) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraron preguntas',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);
    }

    return response()->json($evaluationType, 200); */
}

    function show(EvaluationType $evaluationType)
    {
        return response()->json([
            'data' => $evaluationType,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    function store(StoreEvaluationTypeRequest $request)
    {
/*         // Crea una instanacia del modelo Evaluation type para poder insertar en el modelo question.
        $evaluationType = EvaluationType::getInstance($request->input('question.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo question.
        $type = Catalogue::getInstance($request->input('question.type.id'));

        $evaluationType = new EvaluationType();
        $evaluationType->name = $request->input('question.name');
        $evaluationType->evaluationTypes()->associate($evaluationType);
        $evaluationType->type()->associate($type);
        $evaluationType->save(); */

        return response()->json([
           // 'data' => $evaluationType,
            'msg' => [
                'summary' => 'Pregunta creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateEvaluationTypeRequest $request, EvaluationType $evaluationType)
    {
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        $type = Catalogue::getInstance($request->input('type.id'));

        $evaluationType->name = $request->input('question.name');
        $evaluationType->type()->associate($type);    
        $evaluationType->save();

        return response()->json([
            'data' => $evaluationType,
            'msg' => [
                'summary' => 'Pregunta actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function delete(DeleteEvaluationTypeRequest $request)
    {
        // Es una eliminación lógica
        EvaluationType::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Pregunta(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);

    }


    function uploadImages(UploadImageRequest $request)
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
        return (new FileController())->index($request, Skill::getInstance($request->input('id')));
    }

    function ShowImage($fileId)
    {
        return (new FileController())->show($fileId);
    }

    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Skill::getInstance($request->input('id')));
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
        return (new FileController())->index($request, Skill::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
