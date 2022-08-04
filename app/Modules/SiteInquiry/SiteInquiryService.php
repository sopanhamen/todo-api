<?php

namespace App\Modules\SiteInquiry;

use App\Libraries\Crud\CrudService;
use Illuminate\Support\Facades\Auth;

class SiteInquiryService extends CrudService
{
    protected array $allowedRelations = ['property', 'property.assignee'];

    public function __construct(SiteInquiryRepository $repo)
    {
        parent::__construct($repo);
    }

    protected array $filterable = [
        'property_code' => 'property.code',
        'email' => 'email',
        'phone_number' => 'phone_number',
        'message' => 'message'
    ];

    /**
     * Event to run before each query executes
     *
     * @return callable
     */
    public function onBeforeQuery(): ?callable
    {
        return function ($query) {
            return $query->whereHas(
                'property',
                fn ($q) => $q->where('assignee_id', Auth::id())
            );
        };
    }
}
