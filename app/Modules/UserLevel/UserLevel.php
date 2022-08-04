<?php

namespace App\Modules\UserLevel;

use App\Libraries\Crud\CrudModel;
use App\Modules\User\User;
use OwenIt\Auditing\Contracts\Auditable;

class UserLevel extends CrudModel implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $idColumn = false;

    public $timestamps = false;

    protected $fillable = ['team_id', 'user_id', 'level'];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }
}
