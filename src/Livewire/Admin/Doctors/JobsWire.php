<?php

namespace GIS\StaffDoctors\Livewire\Admin\Doctors;

use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\View\View;
use Livewire\Component;

class JobsWire extends Component
{
    public DoctorInfoInterface $doctorInfo;
    public EmployeeInterface $employee;

    public function render(): View
    {
        return view("sd::livewire.admin.doctors.jobs-wire");
    }
}
