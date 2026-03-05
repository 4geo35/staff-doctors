<?php

namespace GIS\StaffDoctors\Models;

use GIS\ContactPage\Models\Contact;
use GIS\StaffDoctors\Interfaces\ClinicInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model implements ClinicInterface
{
    protected $fillable = [
        "name",
        "address",
        "city",
        "email",
        "phone",
        "company_id",
        "contact_id",
    ];

    public function contact(): BelongsTo
    {
        if (config("contact-page")) {
            $modelClass = config("contact-page.customContactModel") ?? Contact::class;
            return $this->belongsTo($modelClass, "contact_id");
        } else {
            return new BelongsTo($this->newQuery(), $this, "", "", "");
        }
    }

    public function offers(): HasMany
    {
        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        return $this->hasMany($modelClass, "service_id");
    }

    public function getFeedIdAttribute(): string
    {
        return config("staff-doctors.clinicFeedPrefix") . "_{$this->id}";
    }
}
