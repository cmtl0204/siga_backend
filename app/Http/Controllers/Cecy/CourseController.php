<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\Course\IndexCourseRequest;
use App\Http\Requests\Cecy\Course\CourseAprovalCourseRequest;


use Illuminate\Http\Request;

//Models
use App\Models\Cecy\Course;

//FormRequest



class CourseController extends Controller
{
    function index(IndexCourseRequest $request)
    {
        $courses = Course::paginate($request->input('per_page'));
        if (!$courses) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }


        if ($courses->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Cursos',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }

        return response()->json($courses, 200);
    }

    function  courseApproval(CourseAprovalCourseRequest $request)
    {
        
        $course = Course::find($request->input('id'));
        $course->update([
            'status' => $request->input('status'),
            'approval_date' => $request->input('approval_date')
    
        ]);

 


        return response()->json([
            'data' => $course->fresh(),
            'msg' => [
                'summary' => 'Curso actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }


    // public function storeCourse(IndexCourseRequest $request)
    // {

    //     $course = new Course();
    //     $course->code = $request->input('code');
    //     $course->abbreviation = $request->input('abbreviation');
    //     $course->name = $request->input('name');
    //     $course->duration = $request->input('duration');
    //     $course->institution_id = $request->input('institution_id');
    //     $course->anc_id = $request->input('anc_id');
    //     $course->type_id = $request->input('type_id');
    //     $course->modality_id = $request->input('modality_id');
    //     $course->summary = $request->input('summary');
    //     $course->project = $request->input('project');
    //     $course->target_groups = $request->input('target_groups');
    //     $course->participant_type = $request->input('participant_type');
    //     $course->specialty_id = $request->input('specialty_id');
    //     $course->technical_requirements = $request->input('technical_requirements');
    //     $course->general_requirements = $request->input('general_requirements');
    //     $course->objective = $request->input('objective');
    //     $course->cross_cutting_topics = $request->input('cross_cutting_topics');
    //     $course->teaching_strategies = $request->input('teaching_strategies');
    //     $course->bibliographies = $request->input('bibliographies');
    //     $course->free = $request->input('free');
    //     $course->cost = $request->input('cost');
    //     $course->observations = $request->input('observations');
    //     $course->capacitation_type_id = $request->input('capacitation_type_id');
    //     $course->entity_certification_type_id = $request->input('entity_certification_type_id');
    //     $course->certified_type_id = $request->input('certified_type_id');
    //     $course->save();

    //     return response()->json([
    //         'data' => $course->fresh(),
    //         'msg' => [
    //             'summary' => 'Curso creado',
    //             'detail' => 'El registro fue creado',
    //             'code' => '201'
    //         ]
    //     ], 201);
    // }



}
