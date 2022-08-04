<?php

namespace App\Modules\PropertyVisit;

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

class PropertyVisit extends CrudModel implements Auditable
{
    use UuidPrimaryKey, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $table = "property_visits";

    protected $fillable = [
        "client_requirement_id",
        "property_id",
        "person_in_charge_id",
        "visited_at",
        "status",
        "note",
    ];

    protected $casts = [
        'status' => 'integer',
        'visited_at' => 'datetime'
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
