<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Subject\IndexSubjectRequest;
use App\Models\App\Subject;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function indexwefwefew(IndexSubjectRequest $request)
    {

        // get all the Subjects
        /* $subjects = Subject::all();

        return response()->json(['data' => $subjects, 'msg' => [
            'summary' => 'success',
            'detail' => 'La búsqueda se realizo con éxito',
            'code' => '200'
        ]], 200); */
    }

    public function index(IndexSubjectRequest $request)
    {
        if ($request->has('search')) {
            $subjects = Subject::where('description', 'like', '%' . $request->search . '%')
                ->orWhere('objective', 'like', '%' . $request->search . '%')
                ->limit(1000)
                ->get();
        } else {
            $subjects = Subject::all();

        }

        return response()->json(['data' => $subjects, 'msg' => [
            'summary' => 'success',
            'detail' => 'La búsqueda se realizo con éxito',
            'code' => '200'
        ]], 200);
    }


    public function getSubjectByMesh(Request $request)
    {
        $subjects = Subject:: with(['academicPeriod, curricularUnit, formationField'])
            ->where('mesh_id', $request
            ->input('mesh_id'))
            ->get();
        return response()->json(['data' => $subjects, 'msg' => [
            'summary' => 'success',
            'detail' => 'La búsqueda se realizo con éxito',
            'code' => '200'
        ]], 200);
    }


}
