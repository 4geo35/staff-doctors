<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorServiceInterface;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;

class DoctorService extends Model implements DoctorServiceInterface
{
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "gov_id",
        "short",
    ];
}
