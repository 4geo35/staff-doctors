<?php

namespace GIS\StaffDoctors\Observers;

use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;

class DoctorInfoObserver
{
    public function deleted(DoctorInfoInterface $doctorInfo): void
    {
        foreach ($doctorInfo->education as $item) {
            $item->delete();
        }

        foreach ($doctorInfo->jobs as $job) {
            $job->delete();
        }

        foreach ($doctorInfo->certificates as $certificate) {
            $certificate->delete();
        }
    }
}
