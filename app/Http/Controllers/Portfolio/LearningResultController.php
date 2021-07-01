<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;

use App\Models\Portfolio\LearningResult;

use App\Http\Requests\Portfolio\LearningResult\IndexLearningResultRequest;
use App\Http\Requests\Portfolio\LearningResult\StoreLearningResultRequest;
use App\Http\Requests\Portfolio\LearningResult\UpdateLearningResultRequest;

use Illuminate\Http\Request;

class LearningResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexLearningResultRequest $request)
    {
        $learningResult = LearningResult::all();

        return response()->json(['data' => $learningResult, 'msg' => [
           'summary' => 'success',
           'detail' => 'La búsqueda se realizo con éxito',
           'code' => '200'
       ]], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLearningResultRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLearningResultRequest $request, LearningResult $learningResult )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
