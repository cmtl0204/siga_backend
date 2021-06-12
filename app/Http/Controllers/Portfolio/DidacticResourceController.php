<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Requests\Portfolio\DidacticResource\StoreDidacticResourceRequest;
use App\Http\Requests\Portfolio\DidacticResource\IndexDidacticResourceRequest;
use App\Http\Requests\Portfolio\DidacticResource\UpdateDidacticResourceRequest;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\DidacticResource;

use Illuminate\Http\Request;

class DidacticResourceController extends Controller
{



    public function index(IndexDidacticResourceRequest $request)
    {
        //
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDidacticResourceRequest $request)
    {
        //crea instancia de subject
        //$subject = Subject::getInstance($request->input('subject.id'));
        $subject = Subject::find($request->input('pea.subject.id'));
        //crea instancia de school_period_id
        $schoolPeriod = SchoolPeriod::find($request->input('pea.school_period.id'));

        $didacticResource = new DidacticResources();
        $didacticResource->student_assessment = $request->input('didacticResource.resources');

        $didacticResource->subject()->associate($subject);
        $didacticResource->schoolPeriod()->associate($schoolPeriod);


        $didacticResource->save();

        return response()->json([
            'data' => $didacticResource,
            'msg' => [
                'summary' => 'didacticResource creada',
                'detail' => 'El didacticResource fue creado exitósamente',
                'code' => '201'
            ]
        ], 201);
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
        //
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
