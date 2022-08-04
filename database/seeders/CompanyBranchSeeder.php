<?php

namespace Database\Seeders;

// use App\Modules\Company\Company;
// use App\Modules\CompanyBranch\CompanyBranch;
use Illuminate\Database\Seeder;

class CompanyBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::where(['id' => '4f7e0ea0-5437-445f-a579-cd6bb90c98e0'])->first();

        // Use create in order to auto create default team after a branch is created
        CompanyBranch::create([
            'id' => 'a66a0d0e-42fd-4e1e-8623-9bf78b4ad05f',
            'company_id' => $company->id,
            'name' => 'C21M - 371',
            'email' => 'c21m371@info.com',
        ]);

        CompanyBranch::create([
            'id' => '5487bd61-c8ab-4d5c-aa99-7876dda03712',
            'company_id' => $company->id,
            'name' => 'C21M - SEN SOK',
            'email' => 'c21msensok@info.com',
        ]);
    }
}
