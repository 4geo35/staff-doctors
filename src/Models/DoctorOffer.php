<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffPages\Models\Employee;
use GIS\StaffPages\Models\EmployeeDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function getDoctorIsActiveAttribute(): bool
    {
        return (bool) $this->doctor->published_at;
    }

    public function getPriceIsActive(): bool
    {
        $activePrice = $this->prices()
            ->select("id", "published_at")
            ->whereNotNull("published_at")
            ->first();
        if ($activePrice) { return true; } else { return false; }
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->doctor_is_active && $this->price_is_active;
    }
}
