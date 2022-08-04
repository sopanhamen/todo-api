<?php

namespace App\Modules\ContactCompany\Mails;

use App\Modules\Company\Company;
use App\Modules\ContactCompany\ContactCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceivedCompany extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public ContactCompany $contactCompany;
    public Company $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactCompany $contactCompany, Company $company)
    {
        $this->contactCompany = $contactCompany;
        $this->company = $company;

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
            ->from(['address' => $this->company->email])
            ->subject('We Received Your Inquiry')
            ->view('mail.contact-company.confirm_received', [
                'contactCompany' => $this->contactCompany,
                'company' => $this->company
            ]);
    }
}