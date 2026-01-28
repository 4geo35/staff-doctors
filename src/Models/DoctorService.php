<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorServiceInterface;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorService extends Model implements DoctorServiceInterface
{
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "gov_id",
        "short",
    ];

    public function offers(): HasMany
    {
        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        return $this->hasMany($modelClass, "service_id");
    }
}
