<?php

namespace App\Modules\Project;

use App\Modules\Commune\Commune;
use App\Libraries\Crud\CrudModel;
use App\Modules\District\District;
use App\Modules\Province\Province;
use App\Modules\Country\Country;
use App\Modules\Developer\Developer;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\DevelopmentType\DevelopmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends CrudModel implements Auditable
{
    use HasFactory,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $table = "projects";

    protected $fillable = [
        'name', 'development_type_id', 'developer_id', 'total_floor', 'total_unit', 'total_one_bedroom',
        'one_bedroom_size', 'one_bedroom_size_to', 'total_two_bedroom', 'two_bedroom_size', 'two_bedroom_size_to',
        'total_three_bedroom', 'three_bedroom_size', 'three_bedroom_size_to', 'pent_house_size', 'primary_phone',
        'secondary_phone', 'email', 'facebook', 'country_id', 'province_id', 'district_id', 'commune_id', 'village', 'street_no',
        'building_no', 'direction', 'road_con', 'road_dir_width', 'lat_lng', 'image_one', 'image_two', 'image_three',
        'image_four', 'image_five', 'published', 'exclusive',
    ];

    public function developmentType()
    {
        return $this->belongsTo(DevelopmentType::class)
            ->select(['id', 'name']);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class)
            ->select(['id', 'name']);
    }

    public function country()
    {
        return $this->belongsTo(Country::class)
            ->select(['id', 'name', 'iso_code']);
    }

    public function province()
    {
        return $this->belongsTo(Province::class)
            ->select(['id', 'name_en', 'name_km', 'country_id']);
    }

    public function district()
    {
        return $this->belongsTo(District::class)
            ->select(['id', 'name_en', 'name_km', 'province_id']);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class)
            ->select(['id', 'name_en', 'name_km', 'district_id']);
    }
}
