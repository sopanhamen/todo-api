<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingsSeeders::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(CommuneSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(FacilitiesSeeder::class);
        $this->call(PropertyTypeSeeder::class);
        $this->call(UserSeeder::class);

        if (config('app.env') === 'local') {
            // test data seeders here
            $this->call(CompanyBranchSeeder::class);
            // $this->call(CompaniesTestSeeder::class);
            $this->call(UserTestsSeeder::class);
            $this->call(DevelopmentTypeSeeder::class);
            $this->call(DeveloperSeeder::class);
            $this->call(ProjectSeeder::class);
            $this->call(ClientTypeSeeder::class);
            // $this->call(ClientSeeder::class);
            $this->call(PropertiesSeeder::class);
        }
    }
}
