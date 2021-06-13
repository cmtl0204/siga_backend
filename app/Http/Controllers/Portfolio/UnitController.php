<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Unit;
use App\Models\Portfolio\Pea;
use App\Http\Requests\Portfolio\Unit\StoreUnitRequest;
use App\Http\Requests\Portfolio\Unit\IndexUnitRequest;
use App\Http\Requests\Portfolio\Unit\UpdateUnitRequest;


class UnitController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexUnitRequest $request)
    {   
         
         // get all the Units
         $units = Unit::all();

         return response()->json(['data' => $units, 'msg' => [
            'summary' => 'success',
            'detail' => 'Le busqueda se realizo con exito',
            'code' => '200'
        ]], 200);
    }


    public function store(StoreUnitRequest $request)
    {
        $pea = Pea::find($request->input('unit.pea.id'));
        $unit = new Unit();
        $unit->description = $request->input('unit.description');
        $unit->order = $request->input('unit.order');
        $unit->name = $request->input('unit.name');
        $unit->pea()->associate($pea);
        $unit->save();

        return response()->json([
            'data' => $unit,
            'msg' => [
                'summary' => 'Unidad creada',
                'detail' => 'La unidad fue creado exitósamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Portfolio\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Portfolio\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->update($request->all());

        return response()->json([
            'data' => $unit,
            'msg' => [
                'summary' => 'Unidad actualizada',
                'detail' => 'La unidad fue actualizada exitósamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Portfolio\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
