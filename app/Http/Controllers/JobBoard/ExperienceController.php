<?php

namespace App\Http\Controllers\JobBoard;
// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\JobBoard\Professional;
use App\Models\App\Catalogue;
use App\Models\JobBoard\Experience;

// FormRequest
use App\Http\Requests\JobBoard\Experience\DeleteExperienceRequest;
use App\Http\Requests\JobBoard\Experience\StoreExperienceRequest;
use App\Http\Requests\JobBoard\Experience\UpdateExperienceRequest;
use App\Http\Requests\JobBoard\Experience\IndexExperienceRequest;

use App\Http\Controllers\App\FileController;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\App\File\IndexFileRequest;

class ExperienceController extends Controller
{
    // Muestra los datos del profesional con experiencia
    function index(IndexExperienceRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo experiences.
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        // $professional = Professional::getInstance($request->input('professional_id'));
        if ($request->has('search')) {
            $experiences = $professional->experiences()
                ->employer($request->input('search'))
                ->start_date($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $experiences = $professional->experiences()->paginate($request->input('per_page'));
        }

        if ($experiences->count() === 0) {
            return response()->json([
                'data' => $experiences,
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ], 404);
        }
        return response()->json($experiences, 200);
    }

    function show(Experience $experience)
    {
        return response()->json([
            'data' => $experience,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    function store(StoreExperienceRequest $request)
    {
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        // Crea una instanacia del modelo Professional para poder insertar en el modelo experience.
        // $professional = Professional::getInstance($request->input('professional.id'));
        $area = Catalogue::find($request->input('experience.area.id'));

        $experience = new Experience();
        $experience->employer = $request->input('experience.employer');
        $experience->position = $request->input('experience.position');
        $experience->start_date = $request->input('experience.start_date');
        $experience->end_date = $request->input('experience.end_date');
        $experience->activities = $request->input('experience.activities');
        $experience->reason_leave = $request->input('experience.reason_leave');
        $experience->is_working = $request->input('experience.is_working');
        $experience->is_disability = $request->input('experience.is_disability');
        $experience->professional()->associate($professional);
        $experience->area()->associate($area);
        $experience->save();

        return response()->json([
            'data' => $experience,
            'msg' => [
                'summary' => 'experiencia creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    function update(UpdateExperienceRequest $request, Experience $experience)
    {
        $area = Catalogue::find($request->input('experience.area.id'));
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo experience.
      //  $experience = Experience::find($experienceId);

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$experience) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Experiencia no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $experience->employer = $request->input('experience.employer');
        $experience->position = $request->input('experience.position');
        $experience->start_date = $request->input('experience.start_date');
        $experience->end_date = $request->input('experience.end_date');
        $experience->activities = $request->input('experience.activities');
        $experience->reason_leave = $request->input('experience.reason_leave');
        $experience->is_working = $request->input('experience.is_working');
        $experience->is_disability = $request->input('experience.is_disability');
        $experience->area()->associate($area);
        $experience->save();

        return response()->json([
            'data' => $experience,
            'msg' => [
                'summary' => 'Experiencia actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

    function delete(DeleteExperienceRequest $request)
    {
        // Es una eliminación lógica
        Experience::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Experience(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Experience::getInstance($request->input('id')));
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Experience::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}