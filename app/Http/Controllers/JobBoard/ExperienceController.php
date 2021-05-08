<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

// Models
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Experience;

// FormRequest
use App\Http\Requests\JobBoard\Experience\CreateExperienceRequest;
use App\Http\Requests\JobBoard\Experience\UpdateExperienceRequest;
use App\Http\Requests\JobBoard\Experience\IndexExperienceRequest;

class ExperienceController extends Controller
{
    // Muestra los datos del profesional con experiencia
    function index(IndexExperienceRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo experiences.
        $professional = Professional::getInstance($request->input('professional_id'));

        if ($request->has('search')) {
            $experiences = $professional->experiences()
            ->employer($request->input('search'))
            ->start_date($request->input('search'))
            ->paginate($request->input('per_page'));
        } else {
            $experiences = $professional->experiences()->paginate($request->input('per_page'));
        }

        if (sizeof($experiences) === 0) {
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

    function show($experienceId)
    {
            // Valida que el id se un número, si no es un número devuelve un mensaje de error
            if (!is_numeric($experienceId)) {
                return response()->json([
                    'data' => null,
                    'msg' => [
                        'summary' => 'ID no válido',
                        'detail' => 'Intente de nuevo',
                        'code' => '400'
                    ]
                ], 400);
            }
            $experience = Experience::find($experienceId);

            // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
            if (!$experience) {
                return response()->json([
                    'data' => null,
                    'msg' => [
                        'summary' => 'experiencia no encontrada',
                        'detail' => 'Vuelva a intentar',
                        'code' => '404'
                    ]
                ], 404);
            }
            return response()->json([
                'data' => $experience,
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ], 200);

    }

    function store(CreateExperienceRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo experience.
        $professional = Professional::getInstance($request->input('professional.id'));
        $area = Catalogue::getInstance($request->input('area.id'));
        $experience->employer = $request->input('experience.employer');
        $experience->position = $request->input('experience.position');
        $experience->start_date = $request->input('experience.start_date');
        $experience->end_date = $request->input('experience.end_date');
        $experience->activities = $request->input('experience.activities');
        $experience->reason_leave = $request->input('experience.reason_leave');
        $experience->is_working = $request->input('experience.is_working');



        $language = new Language();
        $language->professional()->associate($professional);
        $language->area()->associate($area);
        $language->save();

        return response()->json([
            'data' => $language,
            'msg' => [
                'summary' => 'experiencia creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    function update(UpdateExperienceRequest $request, $experienceId)
    {
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo experience.
        $experience = Experience::find($experienceId);

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
        $area = Catalogue::getInstance($request->input('area.id'));

        $experience->employer = $request->input('experience.employer');
        $experience->position = $request->input('experience.position');
        $experience->start_date = $request->input('experience.start_date');
        $experience->end_date = $request->input('experience.end_date');
        $experience->activities = $request->input('experience.activities');
        $experience->reason_leave = $request->input('experience.reason_leave');
        $experience->is_working = $request->input('experience.is_working');


        $experience->type()->associate($type);
        $experience->save();

        return response()->json([
            'data' => $experience,
            'msg' => [
                'summary' => 'Experiencia actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function destroy($experienceId)
    {
        // Valida que el id se un número, si no es un número devuelve un mensaje de error
        if (!is_numeric($experienceId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        $experience = experience::find($experienceId);

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

        // Es una eliminación lógica
        $experience->delete();

        return response()->json([
            'data' => $experience,
            'msg' => [
                'summary' => 'Experiencia eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }


       /* try {
            $professional = Professional::getInstance($request->input('professional_id'));

            if ($professional) {
                $professionalExperiences = Experience::where('professional_id', $professional->id);

                return response()->json([
                    'pagination' => [
                        'total' => $professionalExperiences->total(),
                        'current_page' => $professionalExperiences->currentPage(),
                        'per_page' => $professionalExperiences->perPage(),
                        'last_page' => $professionalExperiences->lastPage(),
                        'from' => $professionalExperiences->firstItem(),
                        'to' => $professionalExperiences->lastItem()
                    ], 'professionalExperiences' => $professionalExperiences], 200);
            } else {
                return response()->json([
                    'pagination' => [
                        'total' => 0,
                        'current_page' => 1,
                        'per_page' => $request->limit,
                        'last_page' => 1,
                        'from' => null,
                        'to' => null
                    ], 'professionalExperiences' => null], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        } catch (ErrorException $e) {
            return response()->json($e, 500);
        }
    }
    function show($id)
    {
        try {
            $professionalExperiences = Experience::findOrFail($id);
            return response()->json(['professionalExperiences' => $professionalExperiences], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

//Almacena los  Datos creado del profesional que envia//

    function store(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataUser = $data['user'];
            $dataProfessionalExperiences = $data['professionalExperience'];
            $professional = Professional::where('user_id', $dataUser['id'])->first();
            if ($professional) {
                $response = $professional->professionalExperiences()->create([
                    'employer' => strtoupper($dataProfessionalExperiences ['employer']),
                    'position' => strtoupper($dataProfessionalExperiences ['position']),
                    'job_description' => strtoupper($dataProfessionalExperiences ['job_description']),
                    'start_date' => $dataProfessionalExperiences ['start_date'],
                    'end_date' => $dataProfessionalExperiences ['end_date'],
                    'reason_leave' => strtoupper($dataProfessionalExperiences ['reason_leave']),
                    'current_work' => $dataProfessionalExperiences ['current_work'],
                ]);
                return response()->json($response, 201);
            } else {
                return response()->json(null, 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

//Actualiza los datos del profesional
    function update(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataProfessionalExperiences = $data['professionalExperience'];
            $professionalExperience = Experience::findOrFail($dataProfessionalExperiences ['id'])->update([
                'employer' => strtoupper($dataProfessionalExperiences ['employer']),
                'position' => strtoupper($dataProfessionalExperiences ['position']),
                'job_description' => strtoupper($dataProfessionalExperiences ['job_description']),
                'start_date' => $dataProfessionalExperiences ['start_date'],
                'end_date' => $dataProfessionalExperiences ['end_date'],
                'reason_leave' => strtoupper($dataProfessionalExperiences ['reason_leave']),
                'current_work' => $dataProfessionalExperiences ['current_work'],
            ]);
            return response()->json($professionalExperience, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

//Elimina los datos del profesional
    function destroy(Request $request)
    {
        try {
            $professionalExperience = Experience::findOrFail($request->id)->delete();
            return response()->json($professionalExperience, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 400);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }*/

}
