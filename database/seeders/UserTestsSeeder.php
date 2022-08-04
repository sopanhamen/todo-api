<?php

namespace Database\Seeders;

use App\Modules\Common\Enum\Gender;
use App\Modules\Company\Company;
use App\Modules\Contact\Contact;
use App\Modules\User\User;
use App\Modules\UserTeam\Enum\TeamPosition;
use App\Modules\UserTeam\UserTeam;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserTestsSeeder extends Seeder
{
    const ADMIN_ID = 2;
    const BRANCH_MANAGER_ID = 3;
    const TEAM_LEADER_ID = 4;
    const AGENT_ID = 5;

    const PASSWORD = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

    function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::with('branches')->find('4f7e0ea0-5437-445f-a579-cd6bb90c98e0');

        // Profile for C21 Mekong - Head Office
        $branchHeadOffice = $company->branches->first();
        $profileBranchHeadOffice = [
            'company_id' => $branchHeadOffice->company_id,
            'company_branch_id' => $branchHeadOffice->id
        ];
        $this->createCompanyAdmin(1, 'Admin ', $profileBranchHeadOffice);

        // Profile for C21 Mekong - Branch 371  2 - 5
        $branch371 = $company->branches->where('defaulted', false)->first();
        $profileBranch371 = [
            'company_id' => $branch371->company_id,
            'company_branch_id' => $branch371->id
        ];
        $this->createBranchManager(1, 'BM 371', $profileBranch371);
        $this->createLeader(1, 'LD 371', $profileBranch371);
        $this->createAgent(1, 'AG 371', $profileBranch371);

        // Profile for C21 Mekong - Branch Sen Sok  6 - 9
        $lastBranch = $company->branches->where('defaulted', false)->last()->first();
        $profileLastBranch = ['company_id' => $lastBranch->company_id, 'company_branch_id' => $lastBranch->id];
        $this->createBranchManager(2, 'BM Sen Sok', $profileLastBranch);
        $this->createLeader(2, 'LD Sen Sok', $profileLastBranch);
        $this->createAgent(2, 'AG Sek Sok', $profileLastBranch);

        // Another test company id from 10 - 13
        // $profileAnotherCompany = ['company_id' => 2, 'company_branch_id' => 4];
        // $this->createCompanyAdmin('1B', 'CB Admin 1', $profileAnotherCompany);
        // $this->createBranchManager('1B', 'CB BM 1', $profileAnotherCompany);
        // $this->createLeader('1B', 'CB LD 1', $profileAnotherCompany);
        // $this->createAgent('1B', 'CB Agent 1', $profileAnotherCompany);

        // Create 20 agents in branch 1
        User::factory(20)->create()->each(function (User $user) use ($profileBranch371) {
            $user->assignRole(config('user.default_role.agent.name'));
            $this->createUserProfile($user, TeamPosition::MEMBER->value, $profileBranch371);
        });

        // Create 20 agents in branch 2
        User::factory(20)->create()->each(function (User $user) use ($profileLastBranch) {
            $user->assignRole(config('user.default_role.agent.name'));
            $this->createUserProfile($user, TeamPosition::MEMBER->value, $profileLastBranch);
        });
    }

    private function createCompanyAdmin(mixed $index, string $name, array $profile = [])
    {
        $admin = User::create([
            'name' => $name,
            'phone' => $this->faker->numerify('+855########'),
            'email' => 'admin' . $index . '@test.com',
            'email_verified_at' => now(),
            'password' => self::PASSWORD,
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole(config('user.default_role.admin.name'));

        $this->createUserProfile($admin, null, $profile);
    }

    private function createBranchManager(mixed $index, string $name, array $profile = [])
    {
        $branchManger = User::create([
            'name' => $name,
            'phone' => $this->faker->numerify('+855########'),
            'email' => 'branch_manager' . $index . '@test.com',
            'email_verified_at' => now(),
            'password' => self::PASSWORD,
            'remember_token' => Str::random(10),
        ]);

        $branchManger->assignRole(config('user.default_role.branch_manager.name'));

        // Create profile
        $this->createUserProfile($branchManger, null, $profile);
    }

    private function createLeader(mixed $index, string $name, array $profile = [])
    {
        $leader = User::create([
            'name' => $name,
            'phone' => $this->faker->numerify('+855########'),
            'email' => 'leader' . $index . '@test.com',
            'email_verified_at' => now(),
            'password' => self::PASSWORD,
            'remember_token' => Str::random(10),
        ]);

        $leader->assignRole(
            config('user.default_role.team_leader.name'),
            config('user.default_role.agent.name')
        );

        $this->createUserProfile($leader, TeamPosition::LEADER->value, $profile);
    }

    private function createAgent(mixed $index, string $name, array $profile = [])
    {
        $agent = User::create([
            'name' => $name,
            'phone' => $this->faker->numerify('+855########'),
            'email' => 'agent' . $index . '@test.com',
            'email_verified_at' => now(),
            'password' => self::PASSWORD,
            'remember_token' => Str::random(10),
        ]);

        $agent->assignRole(config('user.default_role.agent.name'));

        $this->createUserProfile($agent, TeamPosition::MEMBER->value, $profile);
    }

    private function createUserProfile(User $user, int $level = null, array $profile = [])
    {
        $contact = Contact::create([
            'name' => $user->name,
            'email' => $user->email,
            'primary_phone' => $user->phone ?? $this->faker->numerify('+855########'),
        ]);

        $profile = $user->profile()->create(array_merge([
            'user_id' => $user->id,
            'gender' => Gender::MALE,
            'contact_id' => $contact->id,
            'position' => $this->faker->jobTitle
        ], $profile));

        // Assign default team to user
        $team = UserTeam::where('company_branch_id', $profile['company_branch_id'])->first();
        $team->users()->syncWithoutDetaching([$user->id => ['level' => $level || TeamPosition::MEMBER]]);
    }
}
