<?php

namespace App\Exports;

// use App\Registration;
use App\Models\Cecy\DetailRegistration;
// use App\Models\Cecy\Course;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegistrationParticipantsExport implements FromView
{
    public function view(): View
    {
        // $course = Course::find(1);
        $detailRegistration = DetailRegistration::with(['detailPlanification'=> function ($detailPlanification){
            $detailPlanification->with(['course'=> function($query){
                $query->with(['cantonDictate'])
                ->with(['courseType'])
                ->with(['modality']);
            }])
            ->with(['instructor' => function($instructor){
                $instructor->with(['responsible'=> function($sex){
                    $sex->with(['sex']);
                }]);
            }]);
        }])
        ->with(['additionalInformation'])
        ->with(['registration'=> function($planification){
            $planification->with(['planification'=> function($status){
                $status->with(['state']);
            }]);
        }])
        ->get();
        return view('reports.cecy.register-participant', 
        [
            //data que quiero generar
            // 'course' => $course,
            'detailRegistration' => $detailRegistration
        ]);
    }
}
