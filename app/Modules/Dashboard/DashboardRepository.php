<?php

namespace App\Modules\Dashboard;

use App\Modules\ClientRequirement\Enum\Result;
use App\Modules\Common\Enum\Banner;
use App\Modules\Property\Enum\ListingOption;
use App\Modules\Property\Enum\ListingStatus;
use App\Modules\Property\Property;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function countAgents($filters): int
    {
        return DB::table('users')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->where('model_has_roles.role_id', config('user.default_role.agent.id'))
            ->whereBetween('users.created_at', [$filters['min_date'], $filters['max_date']])
            ->whereNull('users.deleted_at')
            ->count();
    }

    public function countBranches($filters): int
    {
        return DB::table('company_branches')
            ->whereBetween('created_at', [$filters['min_date'], $filters['max_date']])
            ->whereNull('deleted_at')
            ->count();
    }

    public function countTeams($filters): int
    {
        return DB::table('user_teams')
            ->whereBetween('created_at', [$filters['min_date'], $filters['max_date']])
            ->whereNull('deleted_at')
            ->count();
    }

    public function countAgentsInTeam($filters, $teamId): int
    {
        return DB::table('users')
            ->join('user_levels', 'user_levels.user_id', '=', 'users.id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->whereIn('user_levels.team_id', $teamId)
            ->whereBetween('users.created_at', [$filters['min_date'], $filters['max_date']])
            ->where('model_has_roles.role_id', config('user.default_role.agent.id'))
            ->whereNull('users.deleted_at')
            ->count();
    }

    /**
     * @param array $filters
     * @return Property|object|static|null
     */
    public function propertySummaries(array $filters = [])
    {
        $now = now();

        return DB::table('properties')
            ->selectRaw('COUNT(id) as total_properties')
            ->selectRaw('COUNT(CASE WHEN banner = ? THEN 1 ELSE NULL END) as total_banner_no_stand', [Banner::BANNER_NO_STAND])
            ->selectRaw('COUNT(CASE WHEN banner = ? THEN 1 ELSE NULL END) as total_banner_with_stand', [Banner::BANNER_WITH_STAND])
            ->selectRaw('COUNT(CASE WHEN banner = ? THEN 1 ELSE NULL END) as total_no_banner', [Banner::NO_BANNER])
            ->selectRaw('COUNT(CASE WHEN banner IS NULL THEN 1 ELSE NULL END) as total_banner_unknown')
            ->selectRaw('COUNT(CASE WHEN exclusive = true THEN 1 ELSE NULL END) as total_exclusives')
            ->selectRaw('COUNT(CASE WHEN published_on_website = true THEN 1 ELSE NULL END) as total_published_on_web')
            ->selectRaw('COUNT(approved_by) as total_approved')
            ->selectRaw('COUNT(CASE WHEN approved_by IS NULL THEN 1 ELSE NULL END) as total_unapproved')
            ->selectRaw('COUNT(CASE WHEN expired_listing_date < ? THEN id ELSE NULL END) as total_expired', [$now])
            ->selectRaw(
                'COUNT(CASE WHEN listing_status = ? THEN 1 ELSE NULL END) as total_available',
                [ListingStatus::AVAILABLE->value]
            )
            ->selectRaw(
                'COUNT(CASE WHEN listing_status = ? THEN 1 ELSE NULL END) as total_sold',
                [ListingStatus::SOLD->value]
            )
            ->selectRaw(
                'COUNT(CASE WHEN listing_status = ? THEN 1 ELSE NULL END) as total_rented',
                [ListingStatus::RENTED->value]
            )

            ->selectRaw(
                'SUM(CASE WHEN expired_listing_date < ? THEN selling_price ELSE NULL END) as total_expired_value',
                [$now]
            )
            ->selectRaw('SUM(selling_price) as total_selling_value')
            ->selectRaw(
                'SUM(CASE WHEN listing_status = ? THEN selling_price ELSE NULL END) as total_sold_value',
                [ListingStatus::SOLD->value]
            )
            ->selectRaw('SUM(renting_price) as total_renting_value')
            ->selectRaw(
                'SUM(CASE WHEN listing_status = ? THEN renting_price ELSE NULL END) as total_rented_value',
                [ListingStatus::RENTED->value]
            )
            ->when(!empty($filters['user_id']), fn ($query) => $query->where('assignee_id', $filters['user_id']))
            ->when(!empty($filters['team_id']), function ($query) use ($filters) {
                $query->where('team_id', $filters['team_id']);
            })
            ->when(!empty($filters['company_branch_id']), function ($query) use ($filters) {
                $query->where('company_branch_id', $filters['company_branch_id']);
            })
            ->whereDate('listing_date', '>=', $filters['min_date'])
            ->whereDate('listing_date', '<=', $filters['max_date'])
            ->whereNull('deleted_at')
            ->when(
                $filters['listing_type_option'] == ListingOption::LISTING->value ||
                    $filters['listing_type_option'] == ListingOption::UNLISTING->value,
                function ($query) use ($filters) {
                    $query->where('published', $filters['listing_type_option'] == ListingOption::LISTING->value ? true : false);
                }
            )
            ->first();
    }

    public function clientSummaries($filters = [])
    {
        return DB::table('client_requirements')
            ->selectRaw('COUNT(client_requirements.id) as total_requirements')
            ->selectRaw('
                COUNT(
                    CASE WHEN result = \'' . Result::IN_PROGRESS->value . '\' THEN client_requirements.id
                    ELSE NULL END
                ) as total_active_requirements
            ')
            ->selectRaw('
                COUNT(
                    CASE WHEN result = \'' . Result::SUCCESS->value . '\' THEN client_requirements.id
                    ELSE NULL END
                ) as total_closed_requirements
            ')
            ->when(!empty($filters['created_by']), fn ($query) => $query->where('created_by', $filters['user_id']))
            ->whereBetween('client_requirements.created_at', [$filters['min_date'], $filters['max_date']])
            ->first();
    }

    public function countPropertiesByLocation($filters = [])
    {
        return DB::table('properties')
            ->select(
                DB::raw('COUNT(properties.id) as number_of_properties'),
                'districts.name_km',
                'districts.name_en'
            )
            ->join('districts', 'districts.id', '=', 'properties.district_id')
            ->when(!empty($filters['user_id']), fn ($query) => $query->where('assignee_id', $filters['user_id']))
            ->when(!empty($filters['team_id']), function ($query) use ($filters) {
                $query->where('team_id', $filters['team_id']);
            })
            ->when(!empty($filters['company_branch_id']), function ($query) use ($filters) {
                $query->where('company_branch_id', $filters['company_branch_id']);
            })
            ->whereBetween('properties.listing_date', [$filters['min_date'], $filters['max_date']])
            ->whereNull('properties.deleted_at')
            ->groupBy('districts.name_en', 'districts.name_km')
            ->orderBy('number_of_properties', 'desc')
            ->when($filters['listing_type_option'] !== ListingOption::ALL->value, function ($query) use ($filters) {
                $query->where('properties.published', $filters['listing_type_option'] == ListingOption::LISTING->value ? true : false);
            })
            ->get();
    }

    public function countPropertiesByDeveloper($filters = [])
    {
        return DB::table('properties')
            ->select(
                DB::raw('COUNT(properties.id) as number_of_properties'),
                'developers.name',
            )
            ->join('developers', 'developers.id', '=', 'properties.developer_id')
            ->when($filters['listing_type_option'] !== ListingOption::ALL->value, function ($query) use ($filters) {
                $query->where('properties.published', $filters['listing_type_option'] == ListingOption::LISTING->value ? true : false);
            })
            ->when(!empty($filters['user_id']), fn ($query) => $query->where('assignee_id', $filters['user_id']))
            ->when(!empty($filters['team_id']), function ($query) use ($filters) {
                $query->where('team_id', $filters['team_id']);
            })
            ->when(!empty($filters['company_branch_id']), function ($query) use ($filters) {
                $query->where('company_branch_id', $filters['company_branch_id']);
            })
            ->whereBetween('properties.listing_date', [$filters['min_date'], $filters['max_date']])
            ->whereNull('properties.deleted_at')
            ->groupBy('developers.name')
            ->orderBy('number_of_properties', 'desc')
            ->get();
    }

    public function countPropertiesByProject($filters = [])
    {
        return DB::table('properties')
            ->select(
                DB::raw('COUNT(properties.id) as number_of_properties'),
                'projects.name',
            )
            ->join('projects', 'projects.id', '=', 'properties.project_id')
            ->when($filters['listing_type_option'] !== ListingOption::ALL->value, function ($query) use ($filters) {
                $query->where('properties.published', $filters['listing_type_option'] == ListingOption::LISTING->value ? true : false);
            })
            ->when(!empty($filters['user_id']), fn ($query) => $query->where('assignee_id', $filters['user_id']))
            ->when(!empty($filters['team_id']), function ($query) use ($filters) {
                $query->where('team_id', $filters['team_id']);
            })
            ->when(!empty($filters['company_branch_id']), function ($query) use ($filters) {
                $query->where('company_branch_id', $filters['company_branch_id']);
            })
            ->whereBetween('properties.listing_date', [$filters['min_date'], $filters['max_date']])
            ->whereNull('properties.deleted_at')
            ->groupBy('projects.name')
            ->orderBy('number_of_properties', 'desc')
            ->get();
    }

    public function countPropertiesByPropertyTypeGroup($filters = [])
    {
        return DB::table('properties')
            ->select(
                DB::raw('COUNT(properties.id) as number_of_properties'),
                'property_types.property_type_group',
            )
            ->join('property_types', 'property_types.id', '=', 'properties.property_type_id')
            ->when($filters['listing_type_option'] !== ListingOption::ALL->value, function ($query) use ($filters) {
                $query->where('properties.published', $filters['listing_type_option'] == ListingOption::LISTING->value ? true : false);
            })
            ->when(!empty($filters['user_id']), fn ($query) => $query->where('assignee_id', $filters['user_id']))
            ->when(!empty($filters['team_id']), function ($query) use ($filters) {
                $query->where('team_id', $filters['team_id']);
            })
            ->when(!empty($filters['company_branch_id']), function ($query) use ($filters) {
                $query->where('company_branch_id', $filters['company_branch_id']);
            })
            ->whereBetween('properties.listing_date', [$filters['min_date'], $filters['max_date']])
            ->whereNull('properties.deleted_at')
            ->groupBy('property_types.property_type_group')
            ->orderBy('number_of_properties', 'desc')
            ->get();
    }

    public function countPropertiesByDate($filters = [])
    {
        return DB::table('properties')
            ->select(
                'listing_date as date',
                DB::raw('count(*) as number_of_properties')
            )
            ->when($filters['listing_type_option'] !== ListingOption::ALL->value, function ($query) use ($filters) {
                $query->where('published', $filters['listing_type_option'] == ListingOption::LISTING->value ? true : false);
            })
            ->when(!empty($filters['user_id']), fn ($query) => $query->where('assignee_id', $filters['user_id']))
            ->when(!empty($filters['team_id']), function ($query) use ($filters) {
                $query->where('team_id', $filters['team_id']);
            })
            ->when(!empty($filters['company_branch_id']), function ($query) use ($filters) {
                $query->where('company_branch_id', $filters['company_branch_id']);
            })
            ->whereBetween('listing_date', [$filters['min_date'], $filters['max_date']])
            ->whereNull('deleted_at')

            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function countPropertiesByPriceRange($filters = [])
    {
        return DB::table('properties')
            ->selectRaw('(ROUND(selling_price / 100000) * 100000) as from_price')
            ->selectRaw('(ROUND(selling_price / 100000) * 100000) + 100000 AS to_price')
            ->selectRaw('COUNT(id) as number_of_properties')
            ->when($filters['listing_type_option'] !== ListingOption::ALL->value, function ($query) use ($filters) {
                $query->where('published', $filters['listing_type_option'] == ListingOption::LISTING->value ? true : false);
            })
            ->when(!empty($filters['user_id']), fn ($query) => $query->where('assignee_id', $filters['user_id']))
            ->when(!empty($filters['team_id']), function ($query) use ($filters) {
                $query->where('team_id', $filters['team_id']);
            })
            ->when(!empty($filters['company_branch_id']), function ($query) use ($filters) {
                $query->where('company_branch_id', $filters['company_branch_id']);
            })
            ->whereBetween('listing_date', [$filters['min_date'], $filters['max_date']])
            ->whereNull('deleted_at')
            ->groupBy('from_price')
            ->orderBy('from_price')
            ->get();
    }

    public function countContacts($filters): int
    {
        return DB::table('site_inquiries')
            ->whereBetween('created_at', [$filters['min_date'], $filters['max_date']])
            ->count();
    }

    public function countContactsInTeam($filters, $teamId): int
    {
        return DB::table('site_inquiries')
            ->join('properties', 'properties.id', '=', 'site_inquiries.property_id')
            ->join('user_levels', 'user_levels.user_id', '=', 'properties.assignee_id')
            ->whereIn('user_levels.team_id', $teamId)
            ->whereBetween('site_inquiries.created_at', [$filters['min_date'], $filters['max_date']])
            ->whereNull('properties.deleted_at')
            ->count();
    }

    public function countContactsInBranch($filters, $branchId): int
    {
        return DB::table('site_inquiries')
            ->join('properties', 'properties.id', '=', 'site_inquiries.property_id')
            ->join('user_levels', 'user_levels.user_id', '=', 'properties.assignee_id')
            ->join('user_teams', 'user_teams.id', '=', 'user_levels.team_id')
            ->where('user_teams.company_branch_id', $branchId)
            ->whereBetween('site_inquiries.created_at', [$filters['min_date'], $filters['max_date']])
            ->whereNull('user_teams.deleted_at')
            ->whereNull('properties.deleted_at')
            ->count();
    }

    public function countContactsByAssignee($filters, $userId): int
    {
        return DB::table('site_inquiries')
            ->join('properties', 'properties.id', '=', 'site_inquiries.property_id')
            ->whereBetween('site_inquiries.created_at', [$filters['min_date'], $filters['max_date']])
            ->where('properties.assignee_id', $userId)
            ->whereNull('properties.deleted_at')
            ->count();
    }
}