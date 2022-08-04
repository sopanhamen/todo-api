<?php

namespace App\Modules\SiteInquiry;

use App\Libraries\Crud\CrudRepository;
use App\Modules\SiteInquiry\SiteInquiry;

class SiteInquiryRepository extends CrudRepository
{
    public function __construct(SiteInquiry $siteInquiry)
    {
        parent::__construct($siteInquiry);
    }
}
