<?php

namespace App\Modules\ClientRequirement;

use App\Helpers\StringHelper;
use App\Libraries\Crud\CrudService;
use App\Modules\ClientRequirement\Enum\Result;
use App\Modules\ClientRequirement\Enum\Service;
use App\Modules\ClientRequirement\Enum\Step;
use App\Modules\Property\Enum\ListingStatus;
use App\Modules\PropertyHistory\PropertyHistoryRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientRequirementService extends CrudService
{
    protected array $allowedRelations = [
        'client', 'client.contact',
        'property', 'property.assignee', 'property.ownerContact',
        'visits', 'visits.assignee', 'visits.property', 'visits.property.assignee',
        'payments', 'payments.assignee', 'payments.documents',
        'negotiations', 'negotiations.assignee', 'negotiations.property', 'agreedNegotiation',
        'client.creator', 'client.requirements', 'creator', 'updater', 'preferredPropertyTypes', 'preferredCountries', 'preferredProvinces',
        'preferredDistricts', 'preferredCommunes', 'preferredProjects', 'preferredDevelopers'
    ];

    protected array $filterable = [
        'name' => 'client.contact.name',
        'client_id' => 'client_id',
        'code' => 'code',
        'budget_min' => 'budget_min',
        'budget_max' => 'budget_max',
        'service' => 'service',
        'price_type' => 'price_type',
        'priority' => 'priority',
        'purpose' => 'purpose',
        'specific_place' => 'specific_place',
        'result' => 'result',
        'note' => 'note',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
        'preferred_property_types' => 'preferredPropertyTypes.property_type_id',
        'preferred_projects' => 'preferredProjects.project_id',
        'preferred_developers' => 'preferredDevelopers.developer_id',
        'preferred_countries' => 'preferredCountries.country_id',
        'preferred_provinces' => 'preferredProvinces.province_id',
        'preferred_districts' => 'preferredDistricts.district_id',
        'preferred_communes' => 'preferredCommunes.commune_id',
        'property_id' => 'property_id',
        'property_code' => 'property.code',
        'creator_id' => 'creator.id'
    ];

    protected PropertyHistoryRepository $propertyHistory;

    public function __construct(ClientRequirementRepository $repo, PropertyHistoryRepository $propertyHistory)
    {
        parent::__construct($repo);
        $this->propertyHistory = $propertyHistory;
    }


    /**
     * Event to run before each query executes
     *
     * @return callable
     */
    public function onBeforeQuery(): ?callable
    {
        return function ($query) {
            return $query
                ->when(
                    request('status') === Step::VISIT->value,
                    function ($query) {
                        $query->whereHas('visits');
                        $query->whereDoesntHave('negotiations');
                        $query->whereDoesntHave('payments');
                        $query->where('result', Result::IN_PROGRESS->value);
                    }
                )->when(
                    request('status') === Step::NEGOTIATION->value,
                    function ($query) {
                        $query->whereHas('visits');
                        $query->whereHas('negotiations');
                        $query->whereDoesntHave('payments');
                        $query->where('result', Result::IN_PROGRESS->value);
                    },
                )->when(
                    request('status') === Step::PAYMENT->value,
                    function ($query) {
                        $query->whereHas('visits');
                        $query->whereHas('negotiations');
                        $query->whereHas('payments');
                        $query->where('result', Result::IN_PROGRESS->value);
                    },
                )->when(
                    request('status') === Step::COMPLETION->value,
                    function ($query) {
                        $query->whereHas('visits');
                        $query->whereHas('negotiations');
                        $query->whereHas('payments');
                        $query->where('result', Result::SUCCESS->value);
                    },
                );
        };
    }

    /**
     * Generate new property code
     *
     * @return string Property Code
     */
    public function generateCode(): string
    {
        $latestCode = 0;
        $lastProperty = $this->repo->getLatestAndLock('created_at', ['code']);
        if ($lastProperty) {
            $latestCode = StringHelper::findNumber($lastProperty->code);
        }

        return Str::padLeft($latestCode + 1, 8, '0');
    }

    /**
     * Create one record
     *
     * @param array $payload
     * @return null|ClientRequirement
     */
    public function createOne(array $payload): ?ClientRequirement
    {
        return DB::transaction(function () use ($payload) {
            $payload['code'] = $this->generateCode();
            $requirementData = collect($payload)->except([
                'preferred_property_types',
                'preferred_projects',
                'preferred_developers',
                'preferred_countries',
                'preferred_provinces',
                'preferred_districts',
                'preferred_communes'
            ])->all();

            $requirement = $this->repo->createOne($requirementData);

            $requirement->preferredPropertyTypes()->sync($payload['preferred_property_types']);
            $requirement->preferredProjects()->sync($payload['preferred_projects']);
            $requirement->preferredDevelopers()->sync($payload['preferred_developers']);
            $requirement->preferredCountries()->sync($payload['preferred_countries']);
            $requirement->preferredProvinces()->sync($payload['preferred_provinces']);
            $requirement->preferredDistricts()->sync($payload['preferred_districts']);
            $requirement->preferredCommunes()->sync($payload['preferred_communes']);

            return $this->repo->getOne($requirement->id);
        });
    }

    /**
     * Update one record
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|ClientRequirement
     */
    public function updateOne(string|int $id, array $payload): ?ClientRequirement
    {
        return DB::transaction(function () use ($id, $payload) {
            $requirement = $this->repo->getOneOrFail($id);
            $requirement->preferredPropertyTypes()->sync($payload['preferred_property_types']);
            $requirement->preferredProjects()->sync($payload['preferred_projects']);
            $requirement->preferredDevelopers()->sync($payload['preferred_developers']);
            $requirement->preferredCountries()->sync($payload['preferred_countries']);
            $requirement->preferredProvinces()->sync($payload['preferred_provinces']);
            $requirement->preferredDistricts()->sync($payload['preferred_districts']);
            $requirement->preferredCommunes()->sync($payload['preferred_communes']);

            return $this->repo->updateOne($requirement, $payload);
        });
    }

    /**
     * uuid $id
     * @return ClientRequirement
     */
    public function complete(string $id)
    {
        return DB::transaction(function () use ($id) {
            $requirement = $this->repo->getOneOrFail($id, [
                'relations' => ['client.contact', 'property', 'agreedNegotiation', 'payments']
            ]);

            // check if paid amount is correct
            $paidAmount = $requirement->payments->reduce(fn ($amount, $payment) => $amount + $payment->amount, 0);
            if ($paidAmount < $requirement->agreedNegotiation->last_agreed_price) {
                abort(422);
            }

            $requirement->update(['result' => Result::SUCCESS->value]);

            $propertyHistory = $this->propertyHistory->copy($requirement->property);

            $updateData = [
                'owner_contact_id' => $requirement->client->contact->id,
                'property_history_id' => $propertyHistory->history_id,
                'listing_status' => $requirement->service === Service::BUY->value ? ListingStatus::SOLD->value : ListingStatus::RENTED->value
            ];

            if ($requirement->service === Service::BUY->value) {
                $updateData = [...$updateData, 'selling_price' => $requirement->agreedNegotiation->last_agreed_price];
            } else if ($requirement->service === Service::RENT->value) {
                $updateData = [...$updateData, 'renting_price' => $requirement->agreedNegotiation->last_agreed_price];
            }

            $requirement->property->update($updateData);

            return $requirement;
        });
    }

    /**
     * @params uuid $id
     * @return ClientRequirement
     */
    public function cancel(string $id)
    {
        $requirement = $this->repo->getOneOrFail($id, ['relations' => ['payments']]);

        if ($requirement->payments->count()) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $requirement->update(['result' => Result::CANCELLED->value]);

        return $requirement;
    }
}