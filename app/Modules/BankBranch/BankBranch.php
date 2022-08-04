<?php

namespace App\Modules\BankBranch;

use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\HasAuthors;
use App\Modules\Bank\Bank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class BankBranch extends CrudModel implements Auditable
{
    use HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'bank_id',
        'branch_name',
        'primary_phone',
        'secondary_phone',
        'third_phone',
        'email',
        'image',
        'country_id',
        'province_id',
        'district_id',
        'commune_id',
        'village',
        'street',
        'house',
        'office_type',
        'building',
        'floor',
        'lat_lng',
        'published'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    // public function country()
    // {
    //     return $this->belongsTo(Country::class);
    // }

    // public function province()
    // {
    //     return $this->belongsTo(Province::class);
    // }

    // public function district()
    // {
    //     return $this->belongsTo(District::class);
    // }

    // public function commune()
    // {
    //     return $this->belongsTo(Commune::class);
    // }
}
