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

    public function getHumanPriceAttribute(): string
    {
        if ($this->price - intval($this->price) > 0)
            return number_format($this->price, 2, ",", " ");
        else
            return number_format($this->price, 0, ",", " ");
    }

    public function getHumanDiscountAttribute(): string
    {
        if ($this->discount - intval($this->discount) > 0)
            return number_format($this->discount, 2, ",", " ");
        else
            return number_format($this->discount, 0, ",", " ");
    }
}
