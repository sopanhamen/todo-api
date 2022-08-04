<?php

namespace App\Modules\Setting\Enum;

enum Setting: string
{
        // names
    case SITE_NAME = 'site_name';
    case APP_NAME = 'app_name';

        // path of logo image
    case SITE_LOGO = 'site_logo';

        // path of favicon image
    case FAVICON = 'favicon';

        // property
    case PROPERTY_CODE_PREFIX = 'property_code_prefix';
    case PROPERTY_CODE_DIGIT = 'property_code_digit';

        // watermark
    case WATERMARK_POSITION = 'watermark_position';
    case WATERMARK_PROPERTY = 'property_watermark';
    case WATERMARK_PROJECT = 'project_watermark';
    case WATERMARK_INDICATION = 'indication_watermark';
    case WATERMARK_VALUATION_REPORT = 'valuation_report_watermark';

    case WEBSITE_THEME = 'website_theme';

    
}
