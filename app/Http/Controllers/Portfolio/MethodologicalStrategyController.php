<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\MethodologicalStrategy\StoreMethodologicalStrategyRequest;
use App\Http\Requests\Portfolio\MethodologicalStrategy\UpdateMethodologicalStrategyRequest;
use App\Models\App\Catalogue;
use App\Models\Portfolio\MethodologicalStrategy;
use App\Http\Requests\Portfolio\MethodologicalStrategy\IndexMethodologicalStrategyRequest;
use App\Models\Portfolio\Pea;
use Illuminate\Http\Request;

class MethodologicalStrategyController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMethodologicalStrategyRequest $request)
    {
        $pea = Pea::find($request->input('methodological_strategy.pea.id'));
        $strategy = Catalogue::find($request->input('methodological_strategy.strategy.id'));
        $methodologicalStrategy = new MethodologicalStrategy();
        $methodologicalStrategy->purpose = $request->input('methodological_strategy.purpose');

        $methodologicalStrategy->pea()->associate($pea);
        $methodologicalStrategy->strategy()->associate($strategy);
        $methodologicalStrategy->save();

        return response()->json([
            'data' => $methodologicalStrategy,
            'msg' => [
                'summary' => 'Contenido creado',
                'detail' => 'EL contenido fue creado exitósamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Portfolio\MethodologicalStrategy $methodologicalStrategy
     * @return \Illuminate\Http\Response
     */
    public function show(MethodologicalStrategy $methodologicalStrategy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Portfolio\MethodologicalStrategy $methodologicalStrategy
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMethodologicalStrategyRequest $request, MethodologicalStrategy $methodologicalStrategy)
    {
        $methodologicalStrategy->update($request->all());

        return response()->json([
            'data' => $methodologicalStrategy,
            'msg' => [
                'summary' => 'Unidad actualizada',
                'detail' => 'La unidad fue actualizada exitósamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Portfolio\MethodologicalStrategy $methodologicalStrategy
     * @return \Illuminate\Http\Response
     */
    public function destroy(MethodologicalStrategy $methodologicalStrategy)
    {
        //
    }
}
