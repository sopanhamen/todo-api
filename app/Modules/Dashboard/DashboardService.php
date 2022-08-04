<?php

namespace App\Modules\Dashboard;

use Illuminate\Http\Request;
use App\Modules\User\UserService;

class DashboardService
{
    private DashboardRepository $repo;

    public function __construct(DashboardRepository $repo)
    {
        $this->repo = $repo;
    }

    public function formatCountProperties($propertyData, $limit = 8)
    {
        // take top 8 data
        $topEightItems = $propertyData;
        if ($propertyData->count() > $limit) {
            $topEightItems = $propertyData->slice(0, $limit);
        }

        // count other
        $otherPropertiesCount = 0;
        $other = [];
        $others = [];
        if ($propertyData->count() > $limit) {
            $others = $propertyData->slice($limit);
            $otherPropertiesCount = $others->reduce(function ($carry, $item) {
                return $carry + $item->number_of_properties;
            }, 0);

            $other[] = [
                'name_km' => 'ផ្សេងៗ',
                'name_en' => 'Other',
                'property_type_group' => 'other',
                'name' => 'Other',
                'number_of_properties' => $otherPropertiesCount
            ];
        }

        return [...$topEightItems, ...$other];
    }

    public function getDashboardData(Request $request)
    {
        $user = $request->user();
        $userBranchId = null;
        $userTeamId = [];
        $superAdmin = $user->hasRole(config('user.default_user.super_admin.role_name'));

        if (!$superAdmin) {
            $profile = UserService::basicProfile($user);
            $userBranchId = $profile->company_branch_id;
            $userTeamId = $profile->teams->pluck('id');
        }

        $filters = [
            'min_date' => $request->min_date,
            'max_date' => $request->max_date,
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
            'company_branch_id' => $request->company_branch_id,
            'listing_type_option' => $request->listing_type_option,
        ];

        return [
            'property_summaries' => $this->repo->propertySummaries($filters),
            'client_summaries' => $this->repo->clientSummaries($filters),

            'company_summaries' => [
                'total_agents' => $this->repo->countAgents($filters),
                'total_company_branches' => $this->repo->countBranches($filters),
                'total_teams' => $this->repo->countTeams($filters),
                'total_agents_in_team' =>  $userTeamId ? $this->repo->countAgentsInTeam($filters, $userTeamId) : 0,
            ],

            'contact_summaries' => [
                'total' => $this->repo->countContacts($filters),
                'total_in_branch' => $userBranchId ? $this->repo->countContactsInBranch($filters, $userBranchId) : 0,
                'total_in_team' => $userTeamId ? $this->repo->countContactsInTeam($filters, $userTeamId) : 0,
                'total_by_assignee' => $this->repo->countContactsByAssignee($filters, $user->id),
            ],

            'property_counts_by_location' => $this->formatCountProperties(
                $this->repo->countPropertiesByLocation($filters)
            ),
            'property_counts_by_developer' => $this->formatCountProperties(
                $this->repo->countPropertiesByDeveloper($filters)
            ),
            'property_counts_by_project' => $this->formatCountProperties(
                $this->repo->countPropertiesByProject($filters)
            ),
            'property_counts_by_property_type_group' => $this->formatCountProperties(
                $this->repo->countPropertiesByPropertyTypeGroup($filters)
            ),
            'property_counts_by_date' => $this->repo->countPropertiesByDate($filters),
            'property_counts_by_price_range' => $this->repo->countPropertiesByPriceRange($filters),
        ];
    }
}
