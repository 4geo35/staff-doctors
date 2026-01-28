<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffPages\Models\EmployeeDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorOffer extends Model implements DoctorOfferInterface
{
    protected $fillable = [
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
}
