<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffDoctors\Interfaces\DoctorOfferPriceInterface;
use GIS\StaffPages\Models\Employee;
use GIS\StaffPages\Models\EmployeeDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DoctorOffer extends Model implements DoctorOfferInterface
{
    protected $fillable = [
        "doctor_id",
        "service_id",
        "clinic_id",
        "department_id",

        "oms",
        "appointment",
        "children",
        "adult",
        "house_call",
        "telemedicine",
        "is_base_service",

        "published_at",
    ];

    public function prices(): HasMany
    {
        $modelClass = config("staff-doctors.customDoctorOfferPriceModel") ?? DoctorOfferPrice::class;
        return $this->hasMany($modelClass, "offer_id");
    }

    public function doctor(): BelongsTo
    {
        $modelClass = config("staff-pages.customEmployeeModel") ?? Employee::class;
        return $this->belongsTo($modelClass, "doctor_id");
    }

    public function service(): BelongsTo
    {
        $modelClass = config("staff-doctors.customDoctorServiceModel") ?? DoctorService::class;
        return $this->belongsTo($modelClass, "service_id");
    }

    public function clinic(): BelongsTo
    {
        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        return $this->belongsTo($modelClass, "clinic_id");
    }

    public function department(): BelongsTo
    {
        $modelClass = config("staff-pages.customDepartmentModel") ?? EmployeeDepartment::class;
        return $this->belongsTo($modelClass, "department_id");
    }

    public function requests(): HasMany
    {
        $modelClass = config("staff-doctors.customOfferRequestRecordModel") ?? OfferRequestRecord::class;
        return $this->hasMany($modelClass, "offer_id");
    }

    public function getFeedIdAttribute(): string
    {
        return config("staff-doctors.offerFeedPrefix") . "_{$this->id}";
    }

    public function getFeedUrlAttribute(): string
    {
        return implode("", [
            route("web.employees.doctor", ["employee" => $this->doctor]),
            "?",
            config("staff-doctors.serviceQueryKey"),
            "=",
            $this->service->slug,
            "&",
            config("staff-doctors.offerQueryKey"),
            "=",
            $this->feed_id,
            "#",
            config('staff-doctors.appointmentBlockId')
        ]);
    }

    public function getDoctorIsActiveAttribute(): bool
    {
        return (bool) $this->doctor->published_at;
    }

    public function getPriceIsActiveAttribute(): bool
    {
        $activePrice = $this->prices()
            ->select("id", "published_at")
            ->whereNotNull("published_at")
            ->first();
        if ($activePrice) { return true; } else { return false; }
    }

    public function getActivePriceAttribute(): ?DoctorOfferPriceInterface
    {
        return $this->prices()
            ->whereNotNull("published_at")
            ->first();
    }

    public function getDepartmentIsActiveAttribute(): bool
    {
        return (bool) $this->department->published_at;
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->doctor_is_active && $this->department_is_active && $this->published_at;
    }
}
