<?php

namespace Database\Seeders;

use App\Modules\Permission\Enum\Permission;
use App\Modules\Permission\Permission as PermissionModule;
use Illuminate\Database\Seeder;

class PublishPropertyPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionModule::create([
            'name' => Permission::PUBLISH_ANY_LISTING->value,
            'guard_name' => 'api'
        ]);

        PermissionModule::create([
            'name' => Permission::PUBLISH_COMPANY_LISTING->value,
            'guard_name' => 'api'
        ]);

        PermissionModule::create([
            'name' => Permission::PUBLISH_BRANCH_LISTING->value,
            'guard_name' => 'api'
        ]);

        PermissionModule::create([
            'name' => Permission::PUBLISH_TEAM_LISTING->value,
            'guard_name' => 'api'
        ]);
    }
}
