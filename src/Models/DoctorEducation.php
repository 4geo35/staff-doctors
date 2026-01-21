<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorEducationInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorEducation extends Model implements DoctorEducationInterface
{
    protected $fillable = [
        "organization",
        "finish_year",
        "type",
        "specialization",
    ];

    public function doctorInfo(): BelongsTo
    {
        $modelClass = config("staff-doctors.customDoctorInfoModel") ?? DoctorInfo::class;
        return $this->belongsTo($modelClass, "doctor_info_id");
    }
}
