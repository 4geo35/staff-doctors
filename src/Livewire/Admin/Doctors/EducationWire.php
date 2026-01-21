<?php

namespace GIS\StaffDoctors\Livewire\Admin\Doctors;

use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;
use Illuminate\View\View;
use Livewire\Component;

class EducationWire extends Component
{
    public DoctorInfoInterface $doctorInfo;

    public function render(): View
    {
        return view("sd::livewire.admin.doctors.education-wire");
    }
}
