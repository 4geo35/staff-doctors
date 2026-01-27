<?php

namespace GIS\StaffDoctors\Observers;

use GIS\StaffDoctors\Facades\ClinicActions;
use GIS\StaffDoctors\Interfaces\ClinicInterface;

class ClinicObserver
{
    public function creating(ClinicInterface $clinic): void
    {
        ClinicActions::setValuesFromContact($clinic);
    }
}
