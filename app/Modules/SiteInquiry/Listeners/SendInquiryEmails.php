<?php

namespace App\Modules\SiteInquiry\Listeners;

use App\Modules\SiteInquiry\Events\ReceivedInquiry;
use App\Modules\SiteInquiry\Mails\NotifyAgent;
use App\Modules\SiteInquiry\Mails\ReceivedInquiry as MailsReceivedInquiry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInquiryEmails
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
     * @param  App\Modules\SiteInquiry\Events\ReceivedInquiry  $event
     * @return void
     */
    public function handle(ReceivedInquiry $event)
    {
        Mail::to($event->agent)
            ->send(new NotifyAgent($event->inquiry, $event->agent, $event->property));

        Mail::to($event->inquiry->email)
            ->send(new MailsReceivedInquiry($event->inquiry, $event->agent, $event->property));
    }
}
