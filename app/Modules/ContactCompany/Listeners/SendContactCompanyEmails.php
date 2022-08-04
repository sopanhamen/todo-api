<?php

namespace App\Modules\ContactCompany\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Modules\ContactCompany\Mails\NotifyCompany;
use App\Modules\ContactCompany\Events\ReceivedContactCompany;
use App\Modules\ContactCompany\Mails\ReceivedCompany;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendContactCompanyEmails
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  App\Modules\ContactCompany\Events\ReceivedContactCompany  $event
     * @return void
     */
    public function handle(ReceivedContactCompany $event)
    {
        Mail::to($event->company)
            ->send(new NotifyCompany($event->contactCompany, $event->company));

        Mail::to($event->contactCompany->email)
            ->send(new ReceivedCompany($event->contactCompany, $event->company));
    }
}