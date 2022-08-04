<?php

namespace App\Modules\SiteInquiry\Mails;

use App\Modules\Property\Property;
use App\Modules\SiteInquiry\SiteInquiry;
use App\Modules\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceivedInquiry extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public SiteInquiry $inquiry;
    public User $agent;
    public Property $property;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SiteInquiry $inquiry, User $agent, Property $property)
    {
        $this->inquiry = $inquiry;
        $this->agent = $agent;
        $this->property = $property;

        $this->afterCommit();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(['address' => $this->agent->email, 'name' => $this->agent->name])
            ->subject('We Received Your Inquiry')
            ->view('mail.inquiry.confirm_received', [
                'inquiry' => $this->inquiry,
                'agent' => $this->agent,
                'property' => $this->property
            ]);
    }
}
