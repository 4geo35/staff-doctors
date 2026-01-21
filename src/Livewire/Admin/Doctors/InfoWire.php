<?php

namespace GIS\StaffDoctors\Livewire\Admin\Doctors;

use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class InfoWire extends Component
{
    public DoctorInfoInterface $doctorInfo;
    public EmployeeInterface $employee;

    public bool $displayData = false;

    public function render(): View
    {
        return view("sd::livewire.admin.doctors.info-wire");
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showEdit(): void
    {
        $this->resetFields();
        if (! $this->checkAuth()) { return; }
        $this->displayData = true;
    }

    protected function resetFields(): void
    {

    }

    protected function checkAuth(): bool
    {
        try {
            $this->authorize("update", $this->employee);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("doctor-info-error", "Неавторизованное действие");
            $this->closeData();
            return false;
        }
    }
}
