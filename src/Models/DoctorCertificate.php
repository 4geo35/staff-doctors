<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorCertificateInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorCertificate extends Model implements DoctorCertificateInterface
{
    protected $fillable = [
        "organization",
        "finish_year",
        "name",
    ];

    public function doctorInfo(): BelongsTo
    {
        $modelClass = config("staff-doctors.customDoctorInfoModel") ?? DoctorInfo::class;
        return $this->belongsTo($modelClass, "doctor_info_id");
    }
}
