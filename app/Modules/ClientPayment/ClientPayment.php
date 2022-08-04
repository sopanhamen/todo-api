<?php

namespace App\Modules\ClientPayment;

use App\Modules\User\User;
use App\Modules\Contact\Contact;
use App\Libraries\Crud\CrudModel;
use App\Modules\Property\Property;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Modules\ClientRequirement\ClientRequirement;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientPayment extends CrudModel implements Auditable
{
    use UuidPrimaryKey, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $table = "client_payments";

    protected $casts = [
        "amount" => 'double',
        'payment_date' => 'datetime',
        'next_payment_date' => 'datetime',
    ];

    protected $fillable = [
        "client_requirement_id",
        "property_id",
        "owner_contact_id",
        "person_in_charge_id",
        "payment_date",
        "next_payment_date",
        "note",
        "amount",
    ];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(ClientRequirement::class, 'client_requirement_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PaymentDocument::class, 'client_payment_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'owner_contact_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'person_in_charge_id');
    }
}
