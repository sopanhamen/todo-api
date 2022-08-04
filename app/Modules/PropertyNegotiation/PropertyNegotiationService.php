<?php

namespace App\Modules\PropertyNegotiation;

use App\Libraries\Crud\CrudService;
use App\Modules\Client\Enum\NegotiationStatus;
use App\Modules\ClientRequirement\ClientRequirementRepository;
use App\Modules\Property\Enum\ListingStatus;
use App\Modules\Property\PropertyRepository;
use App\Modules\Property\PropertyService;
use Illuminate\Support\Facades\DB;

class PropertyNegotiationService extends CrudService
{
    protected array $allowedRelations = ['requirement', 'property', 'assignee', 'owner'];

    private PropertyService $propertyService;
    private PropertyRepository $propertyRepo;
    private ClientRequirementRepository $requirementRepo;

    public function __construct(
        PropertyNegotiationRepository $repo,
        PropertyService $propertyService,
        PropertyRepository $propertyRepo,
        ClientRequirementRepository $requirementRepo,
    ) {
        parent::__construct($repo);
        $this->propertyService = $propertyService;
        $this->propertyRepo = $propertyRepo;
        $this->requirementRepo = $requirementRepo;
    }

    public function createOne(array $payload): ?PropertyNegotiation
    {
        return DB::transaction(function () use ($payload) {
            // Get property's owner contact id and put in $payload
            $property = $this->propertyService->getContacts($payload['property_id']);
            $payload['owner_contact_id'] = $property->owner_contact_id;

            $negotiation = parent::createOne($payload);

            if ($payload['status'] === NegotiationStatus::AGREED->value) {
                $this->agreeNegotiation($negotiation);
            }

            return $negotiation;
        });
    }

    /**
     * Update one record
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|PropertyNegotiation
     */
    public function updateOne(string|int $id, array $payload): ?PropertyNegotiation
    {
        return DB::transaction(function () use ($id, $payload) {
            $negotiation = $this->repo->getOneOrFail($id);
            if ($payload['status'] === NegotiationStatus::AGREED->value) {
                $this->agreeNegotiation($negotiation);
            }

            return $this->repo->updateOne($negotiation, $payload);
        });
    }

    /**
     * If status is agreed, don't show property on website
     */
    public function agreeNegotiation($negotiation)
    {
        $property = $this->propertyRepo->updateOneById($negotiation->property_id, [
            'published_on_website' => false,
            'listing_status' => ListingStatus::SOLD
        ]);

        $this->requirementRepo->updateOneById(
            $negotiation->client_requirement_id,
            ['property_id' => $property->id]
        );
    }
}
