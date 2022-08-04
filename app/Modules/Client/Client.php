<?php

namespace App\Modules\Client;

use App\Libraries\Crud\CrudModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
// use App\Modules\Client\Events\ClientCreating;
use App\Modules\ClientRequirement\ClientRequirement;
use App\Modules\ClientRequirement\Enum\Result as RequirementResult;
use App\Modules\ClientType\ClientType;
use App\Modules\Contact\Contact;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Client extends CrudModel implements Auditable
{
    use UuidPrimaryKey,
        Notifiable,
        HasFactory,
        SoftDeletes,
        HasAuthors,
        \OwenIt\Auditing\Auditable;

    // protected $dispatchesEvents = [
    //     'saving' => ClientCreating::class,
    // ];

    protected $casts = [
        'source' => 'integer',
        'gender' => 'integer',
    ];

    protected $fillable = [
        'id',
        "client_type_id",
        "company_id",
        "company_branch_id",
        "team_id",
        'assignee_id',
        'assignor_id',

        // Registration info
        "published",
        "source",

        // Profile
        "profile_picture",

        // Contacts
        'client_contact_id',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'client_contact_id');
    }

    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, 'client_type_id');
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(ClientRequirement::class, 'client_id')->orderBy('created_at', 'desc');
    }

    public function activeRequirements(): HasMany
    {
        return $this->hasMany(ClientRequirement::class, 'client_id')
            ->where('result', RequirementResult::IN_PROGRESS->value)
            ->whereNull('deleted_at');
    }
}
