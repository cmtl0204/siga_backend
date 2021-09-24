<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;

use App\Models\Portfolio\LearningResult;

use App\Http\Requests\Portfolio\LearningResult\IndexLearningResultRequest;
use App\Http\Requests\Portfolio\LearningResult\StoreLearningResultRequest;
use App\Http\Requests\Portfolio\LearningResult\UpdateLearningResultRequest;
use App\Http\Requests\Portfolio\LearningResult\DeleteLearningResultRequest;
use App\Http\Requests\Portfolio\LearningResult\GetParentLearningResultRequest;

use App\Models\Portfolio\Pea;
use App\Models\App\Catalogue;

use Illuminate\Http\Request;

class LearningResultController extends Controller
{



    function index(IndexLearningResultRequest $request)
    {
        if ($request->has('search')) {
            $learningResults = LearningResult::
            code($request->input('search'))
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {

            $learningResults = LearningResult::paginate($request->input('per_page'));
        }

        if ($learningResults->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Unidad de Competencia aqui se actualiza',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($learningResults, 200);


    }


   /*  public function createLearning(Request $request)
    {
        $learningResult = new LearningResult();
        /* $learningResult->pea_id = $request->input('learningResult.pea.id');
        $learningResult->parent_id = $request->input('learningResult.parent.id');
        $learningResult->type_id = $request->input('learningResult.type.id');
        $learningResult->code = $request->input('learningResult.code');
        $learningResult->description = $request->input('learningResult.description');

        $learningResult->save();

        return response()->json([
            'data' => $learningResult,
            'msg' => [
                'summary' => 'Unidad de Competencia creada',
                'detail' => 'El registro fue creado exitosamente',
                'code' => '201'
            ]], 201);

    } */


    public function store(StoreLearningResultRequest $request)
    {

        // Crea una instancia del modelo Pea para poder insertar en el modelo Learning.
         $pea = Pea::find($request->input('learningResult.pea.id'));
        // Crea una instancia del modelo Catalogue para poder insertar en el modelo Learning.
        $parent = LearningResult::find($request->input('learningResult.parent.id'));
        $type = Catalogue::find($request->input('learningResult.type.id'));

        $learningResult = new LearningResult();
        $learningResult->pea_id = $request->input('learningResult.pea.id');
        $learningResult->parent_id = $request->input('learningResult.parent.id');
        $learningResult->type_id = $request->input('learningResult.type.id');
        $learningResult->code = $request->input('learningResult.code');
        $learningResult->description = $request->input('learningResult.description');
         if($parent) {
            $learningResult->parent()->associate($parent);
        }
        $learningResult->type()->associate($type);
        $learningResult->pea()->associate($pea);
        $learningResult->save();

        return response()->json([
            'data' => $learningResult,
            'msg' => [
                'summary' => 'Unidad de Competencia creada',
                'detail' => 'El registro fue creado exitosamente',
                'code' => '201'
            ]], 201);
    }

    public function destroy(LearningResult $learningResult)
    {
        //
    }



    public function show()
  {

   /*  $headers = Catalogue::where('type', 'type_id')->get(["code", "name"]);
    $combos = array(
      "headers" => $headers
    );
    return $combos; */
  }


      function getParentLearningResults(GetParentLearningResultRequest $request)
    {
        $learningResults = LearningResult::whereNull('parent_id')->get();

        if ($learningResults->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Unidades de competencia',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
        return response()->json([
            'data' => $learningResults,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function update(UpdateLearningResultRequest $request, LearningResult $learningResult )
    {


        $parent= LearningResult::find($request->input('learningResult.parent.id'));

        $learningResult->code = $request->input('learningResult.code');
        $learningResult->description = $request->input('learningResult.description');

        if($parent){
            $learningResult->parent()->associate($parent);
        }
        $learningResult->save();

        return response()->json([
            'data' => $learningResult,
            'msg' => [
                'summary' => 'Unidad de Competencia actualizada',
                'detail' => 'El registro fue actualizado correctamente',
                'code' => '201'
            ]], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(DeleteLearningResultRequest $request)

    {
        // Es una eliminación lógica
        LearningResult::destroy($request->input('id'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Unidad de Competencia(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);



    }



    /* function show(LearningResult $learningResult)
    {



        return response()->json([
            'data' => $learningResult,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    } */



}
