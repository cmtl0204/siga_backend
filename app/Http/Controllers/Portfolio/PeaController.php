<?php

namespace App\Http\Controllers\Portfolio;
use App\Http\Controllers\Controller;
use App\Models\App\Catalogue;
use App\Models\Portfolio\Pea;

use App\Http\Requests\Portfolio\Pea\StorePeaRequest;

use App\Http\Requests\Portfolio\Pea\UpdatePeaRequest;

use App\Http\Requests\Portfolio\Pea\IndexPeaRequest;
use App\Models\App\Subject;
use App\Models\App\SchoolPeriod;
use Illuminate\Http\Request;

class PeaController extends Controller
{

    protected $pea;

    public function __construct(Pea $pea)
    {
        $this -> pea = $pea;

    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPeaRequest $pea)
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePeaRequest $request)
    {

        //crea instancia de subject
        //$subject = Subject::getInstance($request->input('subject.id'));
        $subject = Subject::find($request->input('pea.subject.id'));
        //crea instancia de school_period_id
        $schoolPeriod = SchoolPeriod::find($request->input('pea.school_period.id'));
        $pea = new Pea();
        $pea->student_assessment = $request->input('pea.student_assessment');
        $pea->basic_bibliographies = $request->input('pea.basic_bibliographies');
        $pea->complementary_bibliographies = $request->input('pea.complementary_bibliographies');
        $pea->subject()->associate($subject);
        $pea->schoolPeriod()->associate($schoolPeriod);
        $pea->save();

        return response()->json([
            'data' => $pea,
            'msg' => [
                'summary' => 'Pea creada',
                'detail' => 'El sílabo fue creado exitósamente',
                'code' => '201'
            ]], 201);
            //$post = $this->pea->create($request->all());
       // return response()->json(new PeaController($post),201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Portfolio\Pea $pea
     * @return \Illuminate\Http\Response
     */
    public function show(Pea $pea)
    {
        return response()->json(new PeaController($pea), 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Portfolio\Pea $pea
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePeaRequest $request, Pea $pea)
    {
        $pea->update($request->all());
        return response()->json(new PeaController($pea));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Portfolio\Pea $pea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pea $pea)
    {
        $pea->delete();
        return response()->json(['message' => 'eliminado correctamente'], 204); //en vez de message se puede enviar null sin comillas (null,204)
    }
}
