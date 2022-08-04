<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as PermissionModel;
use App\Modules\Permission\Enum\Permission;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $permissions = array_column(Permission::cases(), 'value');
        $data = array_map(function ($permission) use ($now) {
            return [
                'id' => Str::uuid(),
                'name' => $permission,
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => $now
            ];
        }, $permissions);

        PermissionModel::insert($data);
    }
}
