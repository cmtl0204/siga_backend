<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\MethodologicalStrategy;

use App\Http\Requests\Portfolio\MethodologicalStrategy\IndexMethodologicalStrategyRequest;
use App\Http\Requests\Portfolio\MethodologicalStrategy\StoreMethodologicalStrategyRequest;
use App\Http\Requests\Portfolio\MethodologicalStrategy\UpdateMethodologicalStrategyRequest;

use Illuminate\Http\Request;

class MethodologicalStrategyController extends Controller
{

    public function index(IndexMethodologicalStrategyRequest $request)
    {
        //
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMethodologicalStrategyRequest $request)
    {
        //
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
        //
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
