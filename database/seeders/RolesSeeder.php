<?php

namespace Database\Seeders;

use App\Modules\Permission\Enum\Permission;
use App\Modules\Role\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(config('user.default_role.super_admin'));

        $admin = Role::create(config('user.default_role.admin'));
        $admin->givePermissionTo([
            Permission::VIEW_PROPERTY->value,
            Permission::VIEW_COMPANY_PROPERTY_SALE_CONTACT->value,
            Permission::VIEW_COMPANY_PROPERTY_OWNER_CONTACT->value,
            Permission::VIEW_COMPANY_PROPERTY_DOCUMENT->value,
            Permission::CREATE_COMPANY_PROPERTY->value,
            Permission::UPDATE_COMPANY_PROPERTY->value,
            Permission::DELETE_COMPANY_PROPERTY->value,
            Permission::APPROVE_COMPANY_LISTING->value,
            Permission::VIEW_COMPANY_EXCLUSIVE->value,
            Permission::VIEW_CLIENT_TYPE->value,
            Permission::CREATE_CLIENT_TYPE->value,
            Permission::UPDATE_CLIENT_TYPE->value,
            Permission::DELETE_CLIENT_TYPE->value,
            Permission::VIEW_DEVELOPMENT_TYPE->value,
            Permission::CREATE_DEVELOPMENT_TYPE->value,
            Permission::UPDATE_DEVELOPMENT_TYPE->value,
            Permission::DELETE_DEVELOPMENT_TYPE->value,
            Permission::VIEW_PROPERTY_TYPE->value,
            Permission::CREATE_PROPERTY_TYPE->value,
            Permission::UPDATE_PROPERTY_TYPE->value,
            Permission::DELETE_PROPERTY_TYPE->value,
            Permission::VIEW_COMPANY_USER->value,
            Permission::CREATE_COMPANY_USER->value,
            Permission::UPDATE_COMPANY_USER->value,
            Permission::DELETE_COMPANY_USER->value,
            Permission::VIEW_ROLE->value,
            Permission::CREATE_ROLE->value,
            Permission::UPDATE_ROLE->value,
            Permission::DELETE_ROLE->value,
            Permission::VIEW_COMPANY_TEAM->value,
            Permission::CREATE_COMPANY_TEAM->value,
            Permission::UPDATE_COMPANY_TEAM->value,
            Permission::DELETE_COMPANY_TEAM->value,
            Permission::VIEW_LOCATION->value,
            Permission::CREATE_LOCATION->value,
            Permission::UPDATE_LOCATION->value,
            Permission::DELETE_LOCATION->value,
            Permission::VIEW_GENERAL_SETTING->value,
            Permission::UPDATE_GENERAL_SETTING->value,
            Permission::VIEW_EXCLUSIVE->value,
            Permission::VIEW_TEAM_EXCLUSIVE->value,
            Permission::VIEW_BRANCH_EXCLUSIVE->value,
            Permission::VIEW_COMPANY_EXCLUSIVE->value,
            Permission::SET_EXCLUSIVE_AVAILABILITY->value,
            Permission::ADD_EXCLUSIVE_STORY->value,
            Permission::VIEW_PROJECT->value,
            Permission::CREATE_PROJECT->value,
            Permission::UPDATE_PROJECT->value,
            Permission::DELETE_PROJECT->value,
            Permission::VIEW_DEVELOPER->value,
            Permission::CREATE_DEVELOPER->value,
            Permission::UPDATE_DEVELOPER->value,
            Permission::DELETE_DEVELOPER->value,
            Permission::VIEW_COMPANY_CLIENT->value,
            Permission::CREATE_COMPANY_CLIENT->value,
            Permission::UPDATE_COMPANY_CLIENT->value,
            Permission::DELETE_COMPANY_CLIENT->value,
            Permission::VIEW_COMPANY_BRANCH->value,
            Permission::CREATE_COMPANY_BRANCH->value,
            Permission::UPDATE_COMPANY_BRANCH->value,
            Permission::DELETE_COMPANY_BRANCH->value,
            Permission::VIEW_COMPANY_PROPOSAL->value,
            Permission::CREATE_COMPANY_PROPOSAL->value,
            Permission::UPDATE_COMPANY_PROPOSAL->value,
            Permission::DELETE_COMPANY_PROPOSAL->value,
            Permission::VIEW_ANY_LOAN_APPLICATION->value,
            Permission::CREATE_LOAN_APPLICATION->value,
            Permission::UPDATE_ANY_LOAN_APPLICATION->value,
            Permission::DELETE_ANY_LOAN_APPLICATION->value,
            Permission::APPROVE_LOAN_APPLICATION->value,
            Permission::COMMENT_ON_LOAN_APPLICATION->value,
            Permission::ANALYSE_LOAN_APPLICATION->value,
            Permission::PRINT_LOAD_PAYMENT_SCHEDULE->value,
            Permission::VIEW_LOAN_RATE->value,
            Permission::UPDATE_LOAN_RATE->value,
            Permission::VIEW_CASH_FLOW->value,
            Permission::PRINT_CASH_FLOW->value,
            Permission::VIEW_BANK->value,
            Permission::CREATE_BANK->value,
            Permission::UPDATE_BANK->value,
            Permission::DELETE_BANK->value,
            Permission::VIEW_BANK_BRANCH->value,
            Permission::CREATE_BANK_BRANCH->value,
            Permission::UPDATE_BANK_BRANCH->value,
            Permission::DELETE_BANK_BRANCH->value,
            Permission::VIEW_AUDIT_REPORT->value,
            Permission::DOWNLOAD_AUDIT_REPORT->value,
            Permission::VIEW_VALUATION_REPORT->value,
            Permission::CREATE_VALUATION_REPORT->value,
            Permission::UPDATE_VALUATION_REPORT->value,
            Permission::DELETE_VALUATION_REPORT->value,
            Permission::VIEW_EVALUATED_REPORT->value,
            Permission::DOWNLOAD_EVALUATED_REPORT->value,
            Permission::VIEW_COMPANY_DASHBOARD->value,
            Permission::VIEW_BRANCH_DASHBOARD->value,
            Permission::VIEW_TEAM_DASHBOARD->value,
            Permission::PUBLISH_COMPANY_LISTING->value,
        ]);

        $branchManger = Role::create(config('user.default_role.branch_manager'));
        $branchManger->givePermissionTo([
            Permission::VIEW_CLIENT_TYPE->value,
            Permission::VIEW_DEVELOPMENT_TYPE->value,
            Permission::VIEW_PROPERTY_TYPE->value,
            Permission::VIEW_BRANCH_USER->value,
            Permission::CREATE_BRANCH_USER->value,
            Permission::UPDATE_BRANCH_USER->value,
            Permission::DELETE_BRANCH_USER->value,
            Permission::VIEW_ROLE->value,
            Permission::VIEW_BRANCH_TEAM->value,
            Permission::CREATE_BRANCH_TEAM->value,
            Permission::UPDATE_BRANCH_TEAM->value,
            Permission::DELETE_BRANCH_TEAM->value,
            Permission::VIEW_LOCATION->value,
            Permission::VIEW_PROPERTY->value,
            Permission::VIEW_BRANCH_PROPERTY_SALE_CONTACT->value,
            Permission::VIEW_BRANCH_PROPERTY_OWNER_CONTACT->value,
            Permission::VIEW_BRANCH_PROPERTY_DOCUMENT->value,
            Permission::CREATE_BRANCH_PROPERTY->value,
            Permission::UPDATE_BRANCH_PROPERTY->value,
            Permission::DELETE_BRANCH_PROPERTY->value,
            Permission::APPROVE_BRANCH_LISTING->value,
            Permission::VIEW_BRANCH_EXCLUSIVE->value,
            Permission::SET_EXCLUSIVE_AVAILABILITY->value,
            Permission::ADD_EXCLUSIVE_STORY->value,
            Permission::VIEW_PROJECT->value,
            Permission::VIEW_DEVELOPER->value,
            Permission::VIEW_BRANCH_CLIENT->value,
            Permission::CREATE_BRANCH_CLIENT->value,
            Permission::UPDATE_BRANCH_CLIENT->value,
            Permission::DELETE_BRANCH_CLIENT->value,
            Permission::VIEW_COMPANY_BRANCH->value,
            Permission::VIEW_BRANCH_PROPOSAL->value,
            Permission::CREATE_BRANCH_PROPOSAL->value,
            Permission::UPDATE_BRANCH_PROPOSAL->value,
            Permission::DELETE_BRANCH_PROPOSAL->value,
            Permission::VIEW_ANY_LOAN_APPLICATION->value,
            Permission::UPDATE_ANY_LOAN_APPLICATION->value,
            Permission::DELETE_ANY_LOAN_APPLICATION->value,
            Permission::APPROVE_LOAN_APPLICATION->value,
            Permission::COMMENT_ON_LOAN_APPLICATION->value,
            Permission::ANALYSE_LOAN_APPLICATION->value,
            Permission::PRINT_LOAD_PAYMENT_SCHEDULE->value,
            Permission::VIEW_LOAN_RATE->value,
            Permission::UPDATE_LOAN_RATE->value,
            Permission::VIEW_CASH_FLOW->value,
            Permission::PRINT_CASH_FLOW->value,
            Permission::VIEW_BANK->value,
            Permission::VIEW_BANK_BRANCH->value,
            Permission::VIEW_AUDIT_REPORT->value,
            Permission::DOWNLOAD_AUDIT_REPORT->value,
            Permission::VIEW_VALUATION_REPORT->value,
            Permission::VIEW_EVALUATED_REPORT->value,
            Permission::DOWNLOAD_EVALUATED_REPORT->value,
            Permission::VIEW_BRANCH_DASHBOARD->value,
            Permission::VIEW_TEAM_DASHBOARD->value,
            Permission::PUBLISH_BRANCH_LISTING->value,
        ]);

        $leader = Role::create(config('user.default_role.team_leader'));
        $leader->givePermissionTo([
            Permission::VIEW_PROJECT->value,
            Permission::VIEW_PROPERTY->value,
            Permission::VIEW_TEAM_PROPERTY_SALE_CONTACT->value,
            Permission::VIEW_TEAM_PROPERTY_OWNER_CONTACT->value,
            Permission::VIEW_TEAM_PROPERTY_DOCUMENT->value,
            Permission::CREATE_TEAM_PROPERTY->value,
            Permission::UPDATE_TEAM_PROPERTY->value,
            Permission::DELETE_TEAM_PROPERTY->value,
            Permission::APPROVE_TEAM_LISTING->value,
            Permission::VIEW_TEAM_EXCLUSIVE->value,
            Permission::VIEW_PROPERTY_TYPE->value,
            Permission::VIEW_TEAM_CLIENT->value,
            Permission::CREATE_TEAM_CLIENT->value,
            Permission::UPDATE_TEAM_CLIENT->value,
            Permission::DELETE_TEAM_CLIENT->value,
            Permission::VIEW_CLIENT_TYPE->value,
            Permission::VIEW_TEAM_USER->value,
            Permission::CREATE_TEAM_USER->value,
            Permission::UPDATE_TEAM_USER->value,
            Permission::DELETE_TEAM_USER->value,
            Permission::VIEW_LOCATION->value,
            Permission::VIEW_GENERAL_SETTING->value,
            Permission::VIEW_TEAM_DASHBOARD->value,
            Permission::PUBLISH_TEAM_LISTING->value,
        ]);

        $agent = Role::create(config('user.default_role.agent'));
        $agent->givePermissionTo([
            Permission::VIEW_PROJECT->value,
            Permission::VIEW_DEVELOPER->value,
            Permission::VIEW_PROPERTY->value,
            Permission::CREATE_PROPERTY->value,
            Permission::UPDATE_PROPERTY->value,
            Permission::DELETE_PROPERTY->value,
            Permission::VIEW_EXCLUSIVE->value,
            Permission::VIEW_TEAM_EXCLUSIVE->value,
            Permission::VIEW_PROPERTY_TYPE->value,
            Permission::VIEW_CLIENT->value,
            Permission::CREATE_CLIENT->value,
            Permission::UPDATE_CLIENT->value,
            Permission::DELETE_CLIENT->value,
            Permission::VIEW_CLIENT_TYPE->value,
            Permission::VIEW_TEAM_USER->value,
            Permission::VIEW_LOCATION->value,
        ]);
    }
}
