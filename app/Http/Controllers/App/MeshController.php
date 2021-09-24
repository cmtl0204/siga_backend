<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Career;

use Illuminate\Http\Request;

class MeshController extends Controller
{


    public function index(Request $request)
    {

        $careers = Career::with('meshes')
            -> where ('institution_id', $request
            -> input('institution_id'))
             -> get();


        return response()->json(['data' => $careers, 'msg' => [
            'summary' => 'success',
            'detail' => 'La búsqueda se realizo con éxito',
            'code' => '200'
        ]], 200);
    }




}
