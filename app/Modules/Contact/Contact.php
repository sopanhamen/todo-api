<?php

namespace App\Modules\Contact;

use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Client\Client;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Contact extends CrudModel implements Auditable
{
    use UuidPrimaryKey, SoftDeletes, \OwenIt\Auditing\Auditable;

    public $fillable = [
        // Basic contact info
        'name',
        'email',
        'primary_phone',
        'secondary_phone',

        // Address
        'country_id',
        'province_id',
        'district_id',
        'commune_id',
        'address',
        'street',
        'house',

        // Legal information
        'gender',
        'national_id_number',
        'national_id_image_front',
        'national_id_image_back',
        'passport_number',
        'passport_id_image_front',
        'passport_id_image_back',

        // Socials
        'telegram',
        'line',
        'wechat',
        'facebook',
        'linkedin',
        'instagram',
        'youtube',
        'tiktok',
    ];

    protected $casts = [
        'gender' => 'integer'
    ];

    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'client_contact_id');
    }
}
