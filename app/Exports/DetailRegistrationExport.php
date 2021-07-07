<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Cecy\DetailRegistration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailRegistrationExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $detailRegistration = DetailRegistration::all();
        return view('reports.cecy.form-inscription', ['detailRegistration'=>$detailRegistration]);
    }
}
