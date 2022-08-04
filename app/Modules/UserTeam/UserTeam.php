<?php

namespace App\Modules\UserTeam;

use App\Libraries\Crud\CrudModel;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\CompanyBranch\CompanyBranch;
use App\Modules\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTeam extends CrudModel implements Auditable
{
    use HasFactory,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $table = "user_teams";

    protected $fillable = ['name', 'company_branch_id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_levels', 'team_id')
            ->select('users.id', 'users.name', 'users.phone')
            ->withPivot(['level']);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(CompanyBranch::class, 'company_branch_id');
    }
}
