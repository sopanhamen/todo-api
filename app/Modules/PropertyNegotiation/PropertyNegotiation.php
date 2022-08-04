<?php

namespace App\Modules\PropertyNegotiation;

use App\Libraries\Crud\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\ClientRequirement\ClientRequirement;
use App\Modules\Contact\Contact;
use App\Modules\Property\Property;
use App\Modules\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class PropertyNegotiation extends CrudModel implements Auditable
{
    use UuidPrimaryKey, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $table = "property_negotiations";

    protected $casts = [
        'status' => 'integer',
        'negotiated_at' => 'datetime',
        "last_buyer_price" => 'double',
        "last_owner_price" => 'double',
        "last_agreed_price" => 'double',
    ];

    protected $fillable = [
        "client_requirement_id",
        "property_id",
        "owner_contact_id",
        "person_in_charge_id",
        "negotiated_at",
        "status",
        "note",
        "last_buyer_price",
        "last_owner_price",
        "last_agreed_price",
    ];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(ClientRequirement::class, 'client_requirement_id');
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
