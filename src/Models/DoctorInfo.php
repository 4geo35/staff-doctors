<?php

namespace GIS\StaffDoctors\Models;

use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;
use GIS\StaffPages\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorInfo extends Model implements DoctorInfoInterface
{
    protected $fillable = [
        "experience_years",
        "career_start_date",
        "degree",
        "rank",
        "category",
    ];

    public function employee(): BelongsTo
    {
        $modelClass = config("staff-pages.customEmployeeModel") ?? Employee::class;
        return $this->belongsTo($modelClass, "employee_id");
    }

    public function education(): HasMany
    {
        $modelClass = config("staff-doctors.customDoctorEducationModel") ?? DoctorEducation::class;
        return $this->hasMany($modelClass, "doctor_info_id");
    }

    public function jobs(): HasMany
    {
        $modelClass = config("staff-doctors.customDoctorJobModel") ?? DoctorJob::class;
        return $this->hasMany($modelClass, "doctor_info_id");
    }

    public function certificates(): HasMany
    {
        $modelClass = config("staff-doctors.customDoctorCertificateModel") ?? DoctorCertificate::class;
        return $this->hasMany($modelClass, "doctor_info_id");
    }
}
