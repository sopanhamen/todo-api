<?php

namespace Database\Seeders;

use App\Modules\Permission\Enum\Permission;
use App\Modules\Permission\Permission as PermissionModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransferPropertyPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionModule::create([
            'name' => Permission::TRANSFER_TEAM_PROPERTY->value,
            'guard_name' => 'api'
        ]);

        PermissionModule::create([
            'name' => Permission::TRANSFER_BRANCH_PROPERTY->value,
            'guard_name' => 'api'
        ]);

        PermissionModule::create([
            'name' => Permission::TRANSFER_COMPANY_PROPERTY->value,
            'guard_name' => 'api'
        ]);
    }
}
