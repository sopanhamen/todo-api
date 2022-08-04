<?php

namespace Database\Seeders;

use App\Modules\Common\Enum\Gender;
use App\Modules\CompanyBranch\CompanyBranch;
use App\Modules\User\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create system admin user
        $this->call(UserSystemAdminSeeder::class);

        // Create super admin user
        $user = User::create([
            'id' => config('user.default_user.super_admin.id'),
            'name' => config('user.default_user.super_admin.role_name'),
            'email' => config('user.default_user.super_admin.username'),
            'password' => Hash::make(config('user.default_user.super_admin.password')),
            'email_verified_at' => Carbon::now(),
            'is_default' => true
        ]);

        $user->assignRole(config('user.default_user.super_admin.role_name'));

        $companyBranch = CompanyBranch::select('id', 'company_id')
            ->where('company_id', '4f7e0ea0-5437-445f-a579-cd6bb90c98e0')
            ->first();

        $user->profile()->create([
            'user_id' => $user->id,
            'gender' => Gender::MALE->value,
            'company_id' => $companyBranch->company_id,
            'company_branch_id' => $companyBranch->id
        ]);
    }
}
