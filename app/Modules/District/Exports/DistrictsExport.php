<?php

namespace App\Modules\District\Exports;

use App\Modules\District\District;
use Maatwebsite\Excel\Concerns\FromCollection;

class DistrictsExport implements FromCollection
{
    public function collection()
    {
        return District::all();
    }
}
