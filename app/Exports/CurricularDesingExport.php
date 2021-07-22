<?php

namespace App\Exports;

use App\Models\Authentication\User;
use App\Models\Cecy\Course;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;


class CurricularDesingExport implements FromView
{
    use Exportable;
    public function __construct(int $id)
    {
        $this->id=$id;
    }

    public function view(): View
    {
        $course = Course::with(["personProposal"])->with(["institution"=>function($institution){
            $institution->with(["institution"]);
         }])->find($this->id);

        return view('reports.cecy.diseño-curricular', ['course'=>$course]);
    }
}