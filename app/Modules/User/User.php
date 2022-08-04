<?php

namespace App\Modules\User;

use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Property\Property;
use App\Modules\UserProfile\UserProfile;
use App\Modules\UserTeam\UserTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes,
        HasAuthors,
        HasRoles,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $guard_name = 'api';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'show_on_website',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'show_on_website' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(config('user.default_user.super_admin.role_name'));
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'assignee_id');
    }

    public function publishedProperties(): HasMany
    {
        return $this->hasMany(Property::class, 'assignee_id')
            ->where('published_on_website', true)
            ->where('published', true)
            ->where('listing_status', 1)
            ->whereDate('expired_listing_date', '>=', now());
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(UserTeam::class, 'user_levels', 'user_id', 'team_id')
            ->select('user_teams.id', 'user_teams.company_branch_id', 'user_teams.name')
            ->withPivot(['level']);
    }
}
