<?php

namespace App\Http\Controllers\JobBoard;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\JobBoard\AcademicFormation;
use App\Models\JobBoard\Category;
use App\Models\JobBoard\Professional;

// FormRequest
use App\Http\Requests\JobBoard\AcademicFormation\IndexAcademicFormationRequest;
use App\Http\Requests\JobBoard\AcademicFormation\CreateAcademicFormationRequest;
use App\Http\Requests\JobBoard\AcademicFormation\UpdateAcademicFormationRequest;
use Illuminate\Support\Facades\Request;

class AcademicFormationController extends Controller
{
    function show(AcademicFormation $academicFormation)
    {
        return response()->json([
            'data' => $academicFormation,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }


    function store(Request $request)
    {
        $data = $request->json()->all();
        $dataAcademicFormation = $data['academic_formation'];
        $dataCategory = $data['category'];

        $academicFormation = new AcademicFormation();
        $academicFormation->professional_degree_id = $dataAcademicFormation['professional_degree_id'];
        $academicFormation->registration_date = $dataAcademicFormation['registration_date'];
        $academicFormation->senescyt_code = $dataAcademicFormation['senescyt_code'];
        $academicFormation->has_titling = $dataAcademicFormation['has_titling'];

        $academicFormation->professional()->associate(Professional::firstWhere('user_id', $request->user()->id));
        $academicFormation->category()->associate(Category::findOrFail($dataCategory['id']));

        $academicFormation->save();
    }

    function update(Request $request, $id)
    {
        $data = $request->json()->all();
        $dataAcademicFormation = $data['academic_formation'];
        $dataCategory = $data['category'];

        $academicFormation = AcademicFormation::findOrFail($id);
        $academicFormation->registration_date = $dataAcademicFormation['registration_date'];
        $academicFormation->senescyt_code = $dataAcademicFormation['senescyt_code'];
        $academicFormation->has_titling = $dataAcademicFormation['has_titling'];

        $academicFormation->professional()->associate(Professional::firstWhere('user_id', $request->user()->id));
        $academicFormation->category()->associate(Category::findOrFail($dataCategory['id']));

        $academicFormation->save();
    }

    function destroy(AcademicFormation $academicFormation)
    {
        $academicFormation->delete();

        return response()->json([
            'data' => $academicFormation,
            'msg' => [
                'summary' => 'Información Académica eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]
        ], 201);
    }
}