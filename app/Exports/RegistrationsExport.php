<?php

namespace App\Exports;

// use App\Registration;
use App\Models\Cecy\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegistrationsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Registration::all();
    }
}
