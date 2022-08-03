<?php

namespace App\Modules\Country\Exports;

use App\Modules\Country\Country;
use Maatwebsite\Excel\Concerns\FromCollection;

class CountriesExport implements FromCollection
{
    public function collection()
    {
        return Country::all();
    }
}
