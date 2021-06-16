<?php

namespace App\Http\Controllers\Cecy;

//controlers
use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $data = $request -> json() -> all();
        $status = $data ['prerequisite'] ['status'];
    
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
        //$course = Course::getInstance($request->input('course.id'));

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        //$type = Catalogue::getInstance($request->input('type.id'));

        $prerequisite = new Prerequisite();
        $prerequisite->course_id =  $request -> input('prerequisite.course_id');
        $prerequisite->state()->associate(Status::findOrFail($status['id']));
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

        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        $state= Status::getInstance($request->input('state.id'));
        
        $prerequisite->state()->associate($state);
        $prerequisite->save();

        return response()->json([
            'data' => $prerequisite,
            'msg' => [
                'summary' => 'Habilidad actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    public function delete(DeletePrerequisiteRequest $request, Prerequisite $prerequisite)
    {
         // Es una eliminación lógica
        $prerequisite->delete();

        return response()->json([
            'data' => $prerequisite,
            'msg' => [
                'summary' => 'Habilidad eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }
}
