<?php

namespace App\Modules\Commune\Exports;

use App\Modules\Commune\Commune;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommunesExport implements FromCollection
{
    public function collection()
    {
        return Commune::all();
    }
}
