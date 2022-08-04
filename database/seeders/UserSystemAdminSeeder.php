<?php

namespace Database\Seeders;

use App\Modules\User\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => config('user.default_user.system_admin.id'),
            'name' => config('user.default_user.system_admin.role_name'),
            'email' => config('user.default_user.system_admin.username'),
            'password' => Hash::make(config('user.default_user.system_admin.password')),
            'email_verified_at' => Carbon::now(),
            'is_default' => true
        ]);
    }
}
