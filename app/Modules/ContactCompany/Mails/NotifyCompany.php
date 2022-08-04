<?php

namespace App\Modules\ContactCompany\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Modules\Company\Company;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\ContactCompany\ContactCompany;

class NotifyCompany extends Mailable implements ShouldQueue
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
            ->from(['address' => $this->contactCompany->email, 'name' => 'Website Inquiry'])
            ->subject('New Inquiry From Website')
            ->view('mail.contact-company.notify_company', [
                'contactCompany' => $this->contactCompany,
                'company' => $this->company
            ]);
    }
}