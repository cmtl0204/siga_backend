<?php

namespace App\Http\Controllers\Cecy;

//controlers

use App\Http\Controllers\App\FileController;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
// models
use App\Models\App\Catalogue;
use App\Models\Cecy\Course;
use App\Models\Cecy\Prerequisite;
use App\Models\App\Status;




// fron request
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Prerequisite\DeletePrerequisiteRequest;
use App\Http\Requests\Cecy\Prerequisite\IndexPrerequisiteRequest;
use App\Http\Requests\Cecy\Prerequisite\StorePrerequisiteRequest;
use App\Http\Requests\Cecy\Prerequisite\UpdatePrerequisiteRequest;


class PrerequisiteController extends Controller
{
    public function index(IndexPrerequisiteRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
    $course = Course ::getInstance($request->input('course_id'));

    if ($request->has('search')) {
        $prerequisites = $course->prerequisites()
            
            ->paginate($request->input('per_page'));
    } else {
        $prerequisites = $course->prerequisites()->paginate($request->input('per_page'));
    }

    if ($prerequisites->count() === 0) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraron Habilidades',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);
    }

    return response()->json($prerequisites, 200);
        
    }

    public function show(Prerequisite $prerequisite)
    {
        {

            return response()->json([
                'data' => $prerequisite,
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]], 200);
        } 
    }

    public function store(StorePrerequisiteRequest $request)
    {
        $data = $request -> json() -> all();
        $state = $data ['prerequisite'] ['state'];
    
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
        //$course = Course::getInstance($request->input('course.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        //$type = Catalogue::getInstance($request->input('type.id'));


        $prerequisite = new Prerequisite();
        $prerequisite->course_id =  $request -> input('prerequisite.course_id');
        $prerequisite->state()->associate(Status::findOrFail($state['id']));
        $prerequisite->parent_code_id =  $request -> input('prerequisite.parent_code_id');
        $prerequisite->save();

        return response()->json([
            'data' => $prerequisite,
            'msg' => [
                'summary' => 'prerequisite creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    public function update(UpdatePrerequisiteRequest $request, Prerequisite $prerequisite)
    {

        $data = $request -> json() -> all();
        $state = $data ['prerequisite'] ['state'];
    
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
        //$course = Course::getInstance($request->input('course.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        //$type = Catalogue::getInstance($request->input('type.id'));


        
        $prerequisite->course_id =  $request -> input('prerequisite.course_id');
        $prerequisite->state()->associate(Status::findOrFail($state['id']));
        $prerequisite->parent_code_id =  $request -> input('prerequisite.parent_code_id');
        $prerequisite->save();

        return response()->json([
            'data' => $prerequisite,
            'msg' => [
                'summary' => 'prerequisite creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    public function delete(DeletePrerequisiteRequest $request)
    {
        Prerequisite::destroy($request->input("ids")); 
        // Es una eliminación lógica
        //$detailRegistration->delete();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Detalle(es) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }

    public function uploadFile(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Prerequisite::getInstance($request->input('id')));
    }

    public function updateFile(UpdateFileRequest $request)
    {
        return (new FileController())->update($request, Prerequisite::getInstance($request->input('id')));

    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Prerequisite::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
