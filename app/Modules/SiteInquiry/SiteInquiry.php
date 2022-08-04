<?php

namespace App\Modules\SiteInquiry;

use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Property\Property;
use App\Modules\SiteInquiry\Events\ReceivedInquiry;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteInquiry extends CrudModel implements Auditable
{
    use Notifiable, UuidPrimaryKey, \OwenIt\Auditing\Auditable;

    protected $table = 'site_inquiries';

    protected $fillable = [
        'id',
        'property_id',
        'name',
        'phone_number',
        'email',
        'message',
        'url',
        'status',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ReceivedInquiry::class,
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
