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

    public function orderedEducation(): HasMany
    {
        return $this->education()
            ->orderBy("finish_year", "desc")
            ->orderBy("organization");
    }

    public function jobs(): HasMany
    {
        $modelClass = config("staff-doctors.customDoctorJobModel") ?? DoctorJob::class;
        return $this->hasMany($modelClass, "doctor_info_id");
    }

    public function orderedJobs(): HasMany
    {
        return $this->jobs()
            ->orderBy("period_years", "desc")
            ->orderBy("organization");
    }

    public function certificates(): HasMany
    {
        $modelClass = config("staff-doctors.customDoctorCertificateModel") ?? DoctorCertificate::class;
        return $this->hasMany($modelClass, "doctor_info_id");
    }

    public function orderedCertificates(): HasMany
    {
        return $this->certificates()
            ->orderBy("finish_year", "desc")
            ->orderBy("organization");
    }

    public function getHumanExperienceYearsAttribute(): ?string
    {
        $value = $this->experience_years;
        if (empty($value)) { return $value; }
        $array = [
            $value,
            num2word($value, ["год", "года", "лет"]),
        ];
        return implode(" ", $array);
    }

    public function getHumanStartDateAttribute(): ?string
    {
        $value = $this->career_start_date;
        if (empty($value)) { return $value; }
        return date_helper()->format($value, "Y") . " г.";
    }
}
