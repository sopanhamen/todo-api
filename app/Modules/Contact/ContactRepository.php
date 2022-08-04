<?php

namespace App\Modules\Contact;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Contact\Contact;

class ContactRepository extends CrudRepository
{
    public function __construct(Contact $contact)
    {
        parent::__construct($contact);
    }
}
