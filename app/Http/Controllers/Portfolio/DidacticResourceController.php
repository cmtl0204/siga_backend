<?php

namespace App\Http\Controllers\Portfolio;

use App\Models\Portfolio\Pea;
use App\Models\App\Catalogue;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\DidacticResource;
use App\Http\Requests\Portfolio\DidacticResource\StoreDidacticResourceRequest;
use App\Http\Requests\Portfolio\DidacticResource\UpdateDidacticResourceRequest;

use Illuminate\Http\Request;

class DidacticResourceController extends Controller
{
    public function index()
    {   
         
         // get all the Contents
         $didacticResource = DidacticResource::all();

         return response()->json(['data' => $didacticResource, 'msg' => [
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
    public function store(StoreDidacticResourceRequest $request)
    {
        $pea = Pea::find($request->input('didactic_resource.pea.id'));
        $type = Catalogue::find($request->input('didactic_resource.type.id'));
        $didacticResource = new DidacticResource();
        $didacticResource->resources = $request->input('didactic_resource.resources');
        $didacticResource->pea()->associate($pea);
        $didacticResource->type()->associate($type);
        $didacticResource->save();

        return response()->json([
            'data' => $didacticResource,
            'msg' => [
                'summary' => 'Unidad creada',
                'detail' => 'La unidad fue creado exitósamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Portfolio\DidacticResource $didacticResource
     * @return \Illuminate\Http\Response
     */
    public function show(DidacticResource $didacticResource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Portfolio\DidacticResource $didacticResource
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDidacticResourceRequest $request, DidacticResource $didacticResource)
    {
        $didacticResource->update($request->all());

        return response()->json([
            'data' => $didacticResource,
            'msg' => [
                'summary' => 'Recurso didactico actualizado',
                'detail' => 'El recurso didactico fue actualizado exitósamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Portfolio\DidacticResource $didacticResource
     * @return \Illuminate\Http\Response
     */
    public function destroy(DidacticResource $didacticResource)
    {
        //
    }
}
