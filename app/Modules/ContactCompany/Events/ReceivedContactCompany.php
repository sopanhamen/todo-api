<?php

namespace App\Modules\ContactCompany\Events;

use App\Modules\Company\Company;
use App\Modules\Company\CompanyService;
use App\Modules\ContactCompany\ContactCompany;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class ReceivedContactCompany
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ContactCompany $contactCompany;
    public Company $company;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ContactCompany $contactCompany)
    {
        $this->contactCompany = $contactCompany;

        $companyService = App::make(CompanyService::class);
        $company = $companyService->getCompanyInfo();
        $this->company = $company;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}