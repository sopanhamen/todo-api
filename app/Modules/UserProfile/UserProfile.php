<?php

namespace App\Modules\UserProfile;

use App\Libraries\Crud\CrudModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Company\Company;
use App\Modules\Contact\Contact;
use App\Modules\User\User;
use App\Modules\UserTeam\UserTeam;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class UserProfile extends CrudModel implements Auditable
{
    use HasFactory,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'company_id',
        'company_branch_id',
        'user_id',
        'contact_id',
        'gender',
        'position',
        'experience',
        'skills',
        'profile_picture',
        'profile_picture_disk',
        'language',
        'theme'
    ];

    protected $casts = [
        //
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): belongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function teams()
    {
        return $this->belongsToMany(UserTeam::class, 'user_levels', 'user_id', 'team_id', 'user_id');
    }
}
