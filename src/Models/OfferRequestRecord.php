<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffPages\Models\EmployeeRequestRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferRequestRecord extends Model
{
    protected $fillable = [
        "offer_id",
        "clinic_title",
        "service_title",
        "department_title",
        "price",
    ];

    public function offer(): BelongsTo
    {
        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        return $this->belongsTo($modelClass, "offer_id");
    }

    public function request(): BelongsTo
    {
        $modelClass = config("staff-pages.customEmployeeRequestRecordModel") ?? EmployeeRequestRecord::class;
        return $this->belongsTo($modelClass, "employee_request_id");
    }
}
