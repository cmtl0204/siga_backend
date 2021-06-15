<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Unit;
use App\Models\Portfolio\Content;
use App\Http\Requests\Portfolio\Content\StoreContentRequest;
use App\Http\Requests\Portfolio\Content\UpdateContentRequest;

class ContentController extends Controller
{
    public function index()
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
    public function store(StoreContentRequest $request)
    {
        $unit = Unit::find($request->input('content.unit.id'));
        $content = new Content();
        $content->week = $request->input('content.week');
        $content->contents = $request->input('content.contents');
        $content->teaching_hours = $request->input('content.teaching_hours');
        $content->teaching_activities = $request->input('content.teaching_activities');
        $content->practical_hours = $request->input('content.practical_hours');
        $content->practical_activities = $request->input('content.practical_activities');
        $content->autonomous_hours = $request->input('content.autonomous_hours');
        $content->autonomous_activities = $request->input('content.autonomous_activities');
        $content->observations = $request->input('content.observations');

        $content->unit()->associate($unit);
        $content->save();

        return response()->json([
            'data' => $content,
            'msg' => [
                'summary' => 'Contenido creado',
                'detail' => 'EL contenido fue creado exitósamente',
                'code' => '201'
            ]], 201);
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
    public function update(UpdateContentRequest $request, Content $content)
    {
        $content->update($request->all());

        return response()->json([
            'data' => $content,
            'msg' => [
                'summary' => 'Contenido actualizado',
                'detail' => 'El contenido fue actualizado exitósamente',
                'code' => '201'
            ]], 201);
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
