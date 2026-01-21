<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorJobInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorJob extends Model implements DoctorJobInterface
{
    protected $fillable = [
        "organization",
        "period_years",
        "position",
    ];

    public function doctorInfo(): BelongsTo
    {
        $modelClass = config("staff-doctors.customDoctorInfoModel") ?? DoctorInfo::class;
        return $this->belongsTo($modelClass, "doctor_info_id");
    }
}
