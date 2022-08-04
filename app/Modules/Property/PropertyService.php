<?php

namespace App\Modules\Property;

use App\Modules\User\User;
use Illuminate\Support\Str;
use App\Helpers\StringHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Libraries\Crud\CrudService;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Modules\Contact\ContactService;
use App\Modules\Setting\SettingService;
use App\Modules\Company\CompanyRepository;
use App\Modules\FileUpload\FileUploadService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\PropertyHistory\PropertyHistoryRepository;

class PropertyService extends CrudService
{
    const IMAGE_DIR = 'property/';
    const IMAGE_SIZE_LARGE = [1950, 1275];
    const IMAGE_SIZE_MID = [1080, 706];
    const IMAGE_SIZE_SMALL = [481, 315];
    const IMAGE_SIZE_LARGE_SQUARE = [2000, 2000];
    const IMAGE_SIZE_MID_SQUARE = [1080, 1080];
    const IMAGE_SIZE_SMALL_SQUARE = [480, 480];

    protected array $allowedRelations = [
        'images', 'documents', 'assignee', 'assignee.profile', 'assignor',
        'facilities', 'ownerContact', 'saleContact',
        'propertyType', 'developer', 'project'
    ];

    protected array $filterable = [
        'code' => 'code',
        'company_id' => 'company_id',
        'company_branch_id' => 'company_branch_id',
        'team_id' => 'team_id',
        'property_type_id' => 'property_type_id',
        'developer_id' => 'developer_id',
        'project_id' => 'project_id',
        'listing_date' => 'listing_date',
        'expired_listing_date' => 'expired_listing_date',
        'valuation_report_number' => 'valuation_report_number',
        'listing_purpose' => 'listing_purpose',
        'selling_price' => 'selling_price',
        'renting_price' => 'renting_price',
        'data_source' => 'data_source',
        'title_deed_number' => 'title_deed_number',
        'title_deed_type' => 'title_deed_type',
        'land_size' => 'land_size',
        'country_id' => 'country_id',
        'province_id' => 'province_id',
        'district_id' => 'district_id',
        'commune_id' => 'commune_id',
        'village' => 'village',
        'street' => 'street',
        'house' => 'house',
        'cornered_with' => 'cornered_with',
        'direction' => 'direction',
        'road_condition' => 'road_condition',
        'direct_road_width' => 'direct_road_width',
        'assignee_id' => 'assignee_id',
        'assignor_id' => 'assignor_id',
        'owner_name' => 'ownerContact.name',
        'owner_phone' => 'ownerContact.primary_phone',
        'sale_name' => 'saleContact.name',
        'sale_phone' => 'saleContact.primary_phone',
        'listing_status' => 'listing_status',
        'published' => 'published',
        'exclusive' => 'exclusive',
        'featured' => 'featured',
        'published_on_website' => 'published_on_website',
        'approved_by' => 'approved_by',
        'show_map' => 'show_map',
    ];

    private PropertyImageRepository $propertyImageRepository;
    private PropertyDocumentRepository $propertyDocumentRepository;
    private ContactService $contact;
    private CompanyRepository $companyRepository;
    private FileUploadService $uploadService;
    private PropertyRepository $propertyRepo;
    private PropertyHistoryRepository $propertyHistory;

    public function __construct(
        PropertyRepository $repo,
        PropertyImageRepository $propertyImageRepository,
        PropertyDocumentRepository $propertyDocumentRepository,
        ContactService $contact,
        SettingService $setting,
        FileUploadService $uploadService,
        CompanyRepository $companyRepository,
        PropertyHistoryRepository $propertyHistory
    ) {
        parent::__construct($repo);
        $this->propertyImageRepository = $propertyImageRepository;
        $this->propertyDocumentRepository = $propertyDocumentRepository;
        $this->contact = $contact;
        $this->companyRepository = $companyRepository;
        $this->setting = $setting;
        $this->uploadService = $uploadService;
        $this->propertyRepo = $repo;
        $this->propertyHistory = $propertyHistory;
    }

    public function onBeforeQuery(): ?callable
    {
        // $user = request()->user();
        // if ($user->isSuperAdmin()) {
        //     return null;
        // }

        // return function (Builder $query) use ($user) {
        //     $profile = $user->profile()->first();
        //     return $query->where('company_id', $profile->company_id);
        // };

        return null;
    }

    /**
     * Get one record which is not deleted by specified field (default = "id")
     *
     * @param mixed|null $value
     * @param string $field
     * @return null|Property
     */
    public function getOneOrFail(mixed $value, ?array $options = null): ?Property
    {
        $options = $this->prepareOptions(request()->query());
        $property = $this->repo->getOneOrFail($value, $options);

        if (!request()->user()->can('viewDocument', $property)) {
            $property->unsetRelation('documents');
        }

        if (!request()->user()->can('viewSaleContact', $property)) {
            $property->unsetRelation('saleContact');
        }

        if (!request()->user()->can('viewOwnerContact', $property)) {
            $property->unsetRelation('ownerContact');
        }

        return $property;
    }

    /**
     * Get records into pagination
     *
     * @param array $options
     * @return Collection|LengthAwarePaginator
     */
    public function paginate(?array $options = null): Collection|LengthAwarePaginator
    {
        if ($options['no_pagination'] ?? null) {
            return $this->getMany($options);
        }

        $queryOptions = $this->prepareOptions($options);
        $queryOptions['fields'] = [
            'id',
            'code',
            'company_id' => 'company_id',
            'company_branch_id' => 'company_branch_id',
            'team_id' => 'team_id',
            'property_type_id' => 'property_type_id',
            'assignor_id',
            'assignee_id',
            'selling_price',
            'selling_price_type',
            'renting_price',
            'renting_price_type',
            'listing_purpose',
            'listing_status',
            'listing_date',
            'expired_listing_date',
            'published',
            'exclusive',
            'published',
            'published_on_website',
            'approved_by',
            'show_map',

            // location
            'country_id',
            'province_id',
            'district_id',
            'commune_id',
            'village',
            'street',
            'house',
            'lat_lng',

            // summary detail
            'land_width',
            'land_length',
            'land_size',
            'land_size_unit',
        ];

        // Prevent client from accessing to these information when request api list
        unset($queryOptions['relations']['documents']);
        unset($queryOptions['relations']['saleContact']);
        unset($queryOptions['relations']['ownerContact']);

        // $i = 0;
        // foreach ($queryOptions['filters'] as $item) {
        //     if ($item['field'] === 'listing_date') {
        //         $date = \DateTime::createFromFormat('D M d Y H:i:s e+', $item['value'])->format('Y-m-d');
        //         $queryOptions['filters'][$i]['value'] = $date;
        //     }
        //     $i++;
        // }

        return $this->repo->paginate($queryOptions);
    }

    public function paginateMaps(?array $options = null): Collection|LengthAwarePaginator
    {
        if ($options['no_pagination'] ?? null) {
            return $this->getMany($options);
        }

        $queryOptions = $this->prepareOptions($options);
        $queryOptions['fields'] = [
            'id',
            'property_type_id' => 'property_type_id',
            'lat_lng',
            'published',
            'exclusive',
        ];


        unset($queryOptions['relations']['documents']);
        unset($queryOptions['relations']['saleContact']);
        unset($queryOptions['relations']['ownerContact']);


        return $this->propertyRepo->paginateMaps($queryOptions);
    }

    /**
     * Generate new property code
     *
     * @return string Property Code
     */
    public function generateCode(string $companyId, bool $isActive = true): string
    {
        $company = $this->companyRepository->getOneOrFail($companyId);

        $latestCode = 0;
        $prefix = $company->property_code_prefix;
        $numberOfDigits = $company->property_code_digit;
        if (!$isActive) {
            $prefix = $company->property_code_prefix_unlisting;
            $numberOfDigits = $company->property_code_digit_unlisting;
        }

        $latestCode = $this->propertyRepo->getLatestCode($prefix, $isActive);

        return $prefix . Str::padLeft($latestCode + 1, $numberOfDigits ?? 8, '0');
    }

    /**
     * @param array|Collection $payload
     * @return array
     */
    private function formatData(array|Collection $payload = [], array $extras = []): array
    {
        $general = collect($payload)->except([
            'location',
            'detail',
            'facilities',
            'publishing',
            'other',
            'owner_contact',
            'sale_contact',
            'other_facilities',
            'documents',
            'images'
        ])->all();

        return [
            ...$general,
            ...$payload['location'],
            ...$payload['detail'],
            ...$payload['facilities'],
            ...$payload['publishing'],
            ...$payload['other'],
            ...$extras,
            'listing_date' => $general['listing_date'] ?? now(),
            'assignor_id' => $general['assignor_id'] ?? Auth::id(),
        ];
    }

    /**
     * Check if two contacts are the same
     */
    private function isSameContact(array $saleContact, array $ownerContact,): bool
    {
        if (!$saleContact['primary_phone']) {
            return true;
        }

        return $ownerContact['primary_phone'] === $saleContact['primary_phone'];
    }

    /**
     * Create one record
     *
     * @param array|Collection $payload
     * @return null|Property
     */
    public function createOne(array $payload): ?Property
    {
        return DB::transaction(function () use ($payload) {
            $ownerContact = $this->contact->saveContact($payload['owner_contact']);
            $saleContact = $ownerContact;

            if (!$this->isSameContact($payload['sale_contact'], $payload['owner_contact'])) {
                $saleContact = $this->contact->saveContact($payload['sale_contact']);
            }

            $isActive = $payload['publishing']['published'];
            $code = $this->generateCode($payload['company_id'], $isActive);

            $data = $this->formatData($payload, [
                'code' => $code,
                'unlisting_code' => $isActive ? null : $code,
                'owner_contact_id' => $ownerContact ? $ownerContact->id : null,
                'sale_contact_id' => $saleContact ? $saleContact->id : null,
                'sale_contact_person' => $payload['sale_contact']['contact_person'] ?? null,
            ]);

            $property = $this->repo->createOne($data);
            $property->facilities()->sync($payload['other_facilities']);

            if (!empty($payload['images'])) {
                $property = $this->saveImages($property, $payload['images']);
            }

            if (!empty($payload['documents'])) {
                $property = $this->saveDocuments($property, $payload['documents']);
            }

            return $property;
        });
    }

    /**
     * @param $payload
     * @return array count of saved properties
     */
    public function createMany(array $payload): array
    {
        return DB::transaction(function () use ($payload) {
            $savedProperties = 0;
            $properties = [];
            $now = now();
            foreach ($payload as $row) {
                $ownerContact = $this->contact->saveContact($row['owner_contact'] ?? []);
                $properties[] = $this->formatData($row, [
                    'id' => Str::uuid(),
                    'owner_contact_id' => $ownerContact ? $ownerContact->id : null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $savedProperties++;
            }

            Property::insert($properties);

            return ['saved' => $savedProperties];
        });
    }

    /**
     * @param Property $property
     * @param array Image Paths
     */
    private function saveImages(Property $property, array $images)
    {
        $data = [];
        foreach ($images as $image) {
            $original = $this->uploadService->storage()->get($image['path']);
            $imageContent = Image::make($original);

            $imageWidth = round($imageContent->width());
            $imageHeight = round($imageContent->height());

            // Rectangle image
            $size = ($imageWidth >= 1950) ?  self::IMAGE_SIZE_LARGE : self::IMAGE_SIZE_MID;
            $thumbnailSize = self::IMAGE_SIZE_SMALL;

            // Square image
            if ($imageWidth - $imageHeight >= 20 && $imageWidth - $imageHeight <= 20) {
                $size = $imageWidth >= 2000 ? self::IMAGE_SIZE_LARGE_SQUARE : self::IMAGE_SIZE_MID_SQUARE;
                $thumbnailSize = self::IMAGE_SIZE_SMALL_SQUARE;
            }

            $path = $image['path'];
            $imageName = Str::uuid();
            $large = $this->uploadService->createImage($path, self::IMAGE_DIR, $imageName, $size);
            $thumbnail = $this->uploadService->createImage($path, self::IMAGE_DIR, $imageName, $thumbnailSize);

            $data[] = [
                'path_large' => $large,
                'path_thumbnail' => $thumbnail,
                'storage_disk' => config('filesystems.default'),
            ];


            $this->uploadService->delete($path);
        }

        $property->images()->createMany($data);

        return $property;
    }

    /**
     * @param Property $property
     * @param array Image Paths
     */
    private function saveDocuments(Property $property, array $documents)
    {
        $data = [];
        foreach ($documents as $document) {
            $path = $this->uploadService->moveToRealPath($document['path'], 'property/');
            $data[] = [
                'file_path' => $path,
                'file_type' => $document['file_type'],
                'file_name' => $document['name'],
                'storage_disk' => config('filesystems.default'),
            ];
        }

        $property->documents()->createMany($data);

        return $property;
    }

    /**
     * Update one record
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|Property
     */
    public function updateOne(string|int $id, array $payload): ?Property
    {
        return DB::transaction(function () use ($id, $payload) {
            $record = $this->repo->getOneOrFail($id);

            if ($record->approved_by && $record->code !== $payload['code']) {
                abort(422);
            }

            $ownerContact = $this->contact->saveContact($payload['owner_contact']);
            $saleContact = $ownerContact;
            if (!$this->isSameContact($payload['sale_contact'], $payload['owner_contact'])) {
                $saleContact = $this->contact->saveContact($payload['sale_contact']);
            }

            $data = $this->formatData($payload, [
                'owner_contact_id' => $ownerContact ? $ownerContact->id : null,
                'sale_contact_id' => $saleContact ? $saleContact->id : null,
                'sale_contact_person' => $payload['sale_contact']['contact_person'] ?? null,
                'assignor_id' => auth()->id()
            ]);


            if (
                $payload['owner_contact']['id'] !== $record->owner_contact_id
                || $payload['listing_purpose'] !== $record->listing_purpose
                || $payload['selling_price'] !== $record->selling_price
                || $payload['renting_price'] !== $record->renting_price
            ) {
                $this->propertyHistory->copy($record);
            }

            $property = $this->repo->updateOne($record, $data);
            $property->facilities()->sync($payload['other_facilities']);

            if (!empty($payload['images'])) {
                $images = array_filter($payload['images'], fn ($image) => empty($image['id']));
                $property = $this->saveImages($property, $images);
            }

            if (!empty($payload['documents'])) {
                $documents = array_filter($payload['documents'], fn ($doc) => empty($doc['id']));
                $property = $this->saveDocuments($property, $documents);
            }

            return $property;
        });
    }

    /**
     * @param string $propertyId
     * @param string $imageId
     * @return PropertyImage
     */
    public function deleteImage(string $propertyId, string $imageId): PropertyImage
    {
        $image = $this->propertyImageRepository->getOneOfProperty($imageId, $propertyId);

        $image || abort(404);

        // Delete form disk
        $this->uploadService->delete($image->path_large);
        $this->uploadService->delete($image->path_thumbnail);

        // Delete from DB
        $this->propertyImageRepository->deleteOne($image);

        return $image;
    }

    /**
     * @param string $propertyId
     * @param string $documentId
     * @return PropertyDocument
     */
    public function deleteDocument(string $propertyId, string $documentId): PropertyDocument
    {
        $document = $this->propertyDocumentRepository->getOneOfProperty($documentId, $propertyId);

        $document || abort(404);

        // Delete form disk
        $this->uploadService->delete($document->file_path);

        // Delete from DB
        $this->propertyDocumentRepository->deleteOne($document);

        return $document;
    }

    /**
     * @param string $propertyId
     * @return Property
     */
    public function getContacts(string $propertyId)
    {
        $property = $this->repo->getOneOrFail($propertyId, [
            'relations' => ['assignee', 'saleContact', 'ownerContact'],
            'fields' => [
                'id',
                'company_id',
                'company_branch_id',
                'team_id',
                'assignee_id',
                'assignor_id',
                'sale_contact_person',
                'sale_contact_id',
                'owner_contact_id'
            ]
        ]);

        $user = request()->user();

        if (!$user->can('viewSaleContact', $property)) {
            $property = $property->unsetRelation('saleContact');
        }

        if (!$user->can('viewOwnerContact', $property)) {
            $property = $property->unsetRelation('ownerContact');
        }

        return $property;
    }

    /**
     * @param Property $property
     * @return Property
     */
    public function approve(Property $property): Property
    {
        if ($property->approved_by) {
            abort(403);
        }

        $property->approved_by = Auth::id();
        $property->save();

        return $property;
    }

    /**
     * @param string $fromAgentId
     * @param string $toAgentId
     * @param array $properties
     * @return Collection
     */
    public function transfer(string $fromAgentId, string $toAgentId, array $properties = []): Collection
    {
        return DB::transaction(function () use ($fromAgentId, $toAgentId, $properties) {
            $assignee = User::with('profile')->findOrFail($toAgentId);
            $this->propertyRepo->updatePropertiesAssignee($fromAgentId, $toAgentId, $properties, [
                'company_id' => $assignee->profile->company_id,
                'company_branch_id' => $assignee->profile->company_branch_id,
                'team_id' => $assignee->teams[0]->id,
            ]);

            return Property::wherein('id', $properties)->get();
        });
    }

    /**
     * @param Property $property
     * @return Property
     */
    public function publish(Property $property): Property
    {

        $property->code = $this->generateCode($property->company_id, true);
        $property->published = true;
        $property->save();

        return $property;
    }
}
