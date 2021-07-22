<?php

namespace App\Exports;

// use App\Registration;
use App\Models\Cecy\Topic;
// use App\Models\Cecy\Course;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegisterPothograficExport implements FromView
{
    public function view(): View
    {
        // $course = Course::find(1);
        $topic = Topic::with(['course'])->with(['type'])->get();
        return view('reports.cecy.potografic-registre', 
        [
            //data que quiero generar
            // 'course' => $course,
            'topic' => $topic
        ]);
    }
}
