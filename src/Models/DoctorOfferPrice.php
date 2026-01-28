<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorOfferPriceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorOfferPrice extends Model implements DoctorOfferPriceInterface
{
    protected $fillable = [
        "price",
        "discount",
        "discount_condition",
        "free_condition",
        "published_at",
    ];

    public function offer(): BelongsTo
    {
        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        return $this->belongsTo($modelClass, "offer_id");
    }
}
