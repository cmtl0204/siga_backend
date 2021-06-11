<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Content;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(IndexUnitRequest $request)
    {   
         
         // get all the Contents
         $contents = Content::all();

         return response()->json(['data' => $contents, 'msg' => [
            'summary' => 'success',
            'detail' => 'Le busqueda se realizo con exito',
            'code' => '200'
        ]], 200);
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
     * @param \Portfolio\Content $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Portfolio\Content $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Portfolio\Content $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        //
    }
}
