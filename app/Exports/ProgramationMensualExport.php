<?php

namespace App\Exports;

// use App\Registration;
use App\Models\Cecy\DetailPlanification;
// use App\Models\Cecy\Course;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProgramationMensualExport implements FromView
{
    public function view(): View
    {
        // $course = Course::find(1);
        $detailPlanification = DetailPlanification::with(['course'=> function($user){
            $user->with(['personProposal'=> function($addres){
                $addres->with(['Address'=> function($sector){
                    $sector->with(['sector']);
                }]);
            }])->with(['area'])->with(['courseType']);
        }])->get();
        return view('reports.cecy.programation-mensual', 
        [
            //data que quiero generar
            // 'course' => $course,
            'detailPlanification' => $detailPlanification
        ]);
    }
}
