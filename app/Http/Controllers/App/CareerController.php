<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Career;
use App\Http\Requests\App\Career\IndexCareerRequest;

use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexCareerRequest $request)
    {
        // nombre, modalidad,
        //$careers = Career::with('modality')
        //    ->get();

        if ($request->has('search')) {
            $careers = Career::title($request->input('search'))
                ->description($request->input('search'));
        } else {
            $careers = Career::all();
        }
        if ($careers->count() == 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron carreras',
                    'detail' => 'Intentalo de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
		else{
			return response()->json([
                'data' => $careers,
                'msg' => [
                    'code' => '200'
                ]
            ], 200);
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Career $career
     * @return \Illuminate\Http\Response
     */
    public function show(Career $career)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Career $career
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Career $career)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Career $career
     * @return \Illuminate\Http\Response
     */
    public function destroy(Career $career)
    {
        //
    }
}
