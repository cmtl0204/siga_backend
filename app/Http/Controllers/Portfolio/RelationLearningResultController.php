<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\RelationLearningResult\StoreRelationLearningResultRequest;
use App\Http\Requests\Portfolio\RelationLearningResult\UpdateRelationLearningResultRequest;
use App\Models\App\Catalogue;
use App\Models\Portfolio\RelationLearningResult;

use App\Models\Portfolio\Pea;
use App\Models\Portfolio\LearningResult;

use Illuminate\Http\Request;

class RelationLearningResultController extends Controller
{
    public function index()
    {   
         
         // get all the Contents
         $methodologicalStrategy = RelationLearningResult::all();

         return response()->json(['data' => $methodologicalStrategy, 'msg' => [
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
    public function store(StoreRelationLearningResultRequest $request)
    {
        $pea = Pea::find($request->input('relation_learning_result.pea.id'));
        $learningResult = LearningResult::find($request->input('relation_learning_result.learning_result.id'));
        $contribution = Catalogue::find($request->input('relation_learning_result.contribution.id'));
        $relationLearningResult = new RelationLearningResult();

        $relationLearningResult->pea()->associate($pea);
        $relationLearningResult->learningResult()->associate($learningResult);
        $relationLearningResult->contribution()->associate($contribution);
        $relationLearningResult->save();

        return response()->json([
            'data' => $relationLearningResult,
            'msg' => [
                'summary' => 'Contenido creado',
                'detail' => 'EL contenido fue creado exitósamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Portfolio\RelationLearningResult $relationLearningResult
     * @return \Illuminate\Http\Response
     */
    public function show(RelationLearningResult $relationLearningResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Portfolio\RelationLearningResult $relationLearningResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRelationLearningResultRequest $request, RelationLearningResult $relationLearningResult)
    {
        $relationLearningResult->update($request->all());

        return response()->json([
            'data' => $relationLearningResult,
            'msg' => [
                'summary' => 'Relacion actualizada',
                'detail' => 'La relacion fue actualizada exitósamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Portfolio\RelationLearningResult $relationLearningResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(RelationLearningResult $relationLearningResult)
    {
        //
    }
}
