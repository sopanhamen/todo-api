<?php

namespace App\Modules\ContactCompany;

use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\ContactCompany\Events\ReceivedContactCompany;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class ContactCompany extends CrudModel implements Auditable
{
    use Notifiable, UuidPrimaryKey, \OwenIt\Auditing\Auditable;

    protected $table = 'contact_companies';

    protected $fillable = [
        'id',
        'url',
        'name',
        'phone_number',
        'subject',
        'email',
        'message',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ReceivedContactCompany::class,
    ];
}