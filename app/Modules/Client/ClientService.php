<?php

namespace App\Modules\Client;

use App\Libraries\Crud\CrudService;
use App\Modules\ClientRequirement\ClientRequirementService;
use App\Modules\Contact\ContactRepository;
use App\Modules\Contact\ContactService;
use App\Modules\Permission\Enum\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientService extends CrudService
{
    protected array $allowedRelations = [
        'clientType', 'contact', 'requirements', 'requirements.visits',
        'activeRequirements', 'activeRequirements.visits', 'creator', 'updater'
    ];

    protected array $filterable = [
        'name' => 'contact.name',
        'phone' => 'contact.primary_phone',
        'email' => 'contact.email',
        'company_id' => 'company_id',
        'company_branch_id' => 'company_branch_id',
        'assignee_id' => 'assignee_id',
        'team_id' => 'team_id',

        'client_type_id' => 'client_type_id',
        'source' => 'source',

        'country_id' => 'contact.country_id',
        'province_id' => 'contact.province_id',
        'district_id' => 'contact.district_id',
        'commune_id' => 'contact.commune_id',

        'telegram' => 'contact.telegram',
        'national_id_number' => 'contact.national_id_number',
        'passport_number' => 'contact.passport_number',
        'creator_id' => 'creator.id'
    ];

    protected $requirementService;
    protected $contactService;
    protected $contactRepo;

    public function __construct(
        ClientRepository $repo,
        ClientRequirementService $requirementService,
        ContactService $contactService,
        ContactRepository $contactRepo,
    ) {
        parent::__construct($repo);
        $this->requirementService = $requirementService;
        $this->contactService = $contactService;
        $this->contactRepo = $contactRepo;
    }

    // public function onBeforeQuery(): null|callable
    // {
    //     return function ($query) {
    //         $user = Auth::user();
    //         if ($user->can(Permission::VIEW_BRANCH_CLIENT)) {
    //             return $query->where();
    //         }

    //         return null;
    //     };
    // }

    /**
     * Create one client
     *
     * @param array $payload
     * @return null|Client
     */
    public function createOne(array $payload): ?Client
    {
        return DB::transaction(function () use ($payload) {
            $payload['assignor_id'] = Auth::id();

            if (!empty($payload['contact'])) {
                unset($payload['contact']['id']);
                $contact = $this->contactService->saveContact($payload['contact']);
                $payload['client_contact_id'] = $contact->id;
            }

            $client = $this->repo->createOne($payload);

            if (!empty($payload['requirement'])) {
                $requirement = $this->requirementService->createOne([
                    'client_id' => $client->id,
                    ...$payload['requirement']
                ]);

                // Append requirements to client manually
                $client->setRelation('requirements', [$requirement]);
            }

            return $client;
        });
    }

    /**
     * Update one record
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|Model
     */
    public function updateOne(string|int $id, array $payload): ?Client
    {
        return DB::transaction(function () use ($id, $payload) {
            $client = $this->repo->getOneOrFail(
                $id,
                ['relations' => ['requirements', 'contact']]
            );

            if (!empty($payload['contact'])) {
                $contact = $this->contactService->saveContact($payload['contact'], true);
            }

            return $this->repo->updateOne($client, [
                ...$payload,
                'client_contact_id' => $contact->id
            ]);
        });
    }
}
