<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Pea;

use Illuminate\Http\Request;

class PeaController extends Controller
{
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
     * @param \Portfolio\Pea $pea
     * @return \Illuminate\Http\Response
     */
    public function show(Pea $pea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Portfolio\Pea $pea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pea $pea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Portfolio\Pea $pea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pea $pea)
    {
        //
    }
}
