<?php

namespace App\Modules\User;

use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
// use App\Modules\Property\Property;
use App\Modules\UserProfile\UserProfile;
// use App\Modules\UserTeam\UserTeam;
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
use App\Modules\Card\Cards;

class User extends CrudModel implements Auditable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes,
        HasAuthors,
        HasRoles,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'show_on_website',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function cards() {
        return $this->hasMany(Card::class)->select(['id', 'card_number', 'card_id']);
    }
}
