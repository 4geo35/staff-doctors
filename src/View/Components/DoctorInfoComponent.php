<?php

namespace GIS\StaffDoctors\View\Components;

use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\View\Component;
use Illuminate\View\View;

class DoctorInfoComponent extends Component
{
    public DoctorInfoInterface $doctorInfo;

    public function __construct(
        public EmployeeInterface $employee
    ){
        $this->doctorInfo = $this->employee->doctorInfo ?? $this->employee->doctorInfo()->create();
    }

    public function render(): View
    {
        return view("sd::admin.doctors.components.info-cards");
    }
}
