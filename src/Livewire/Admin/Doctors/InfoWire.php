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

    public int|null $experienceYears = null;
    public string $careerStartDate = "";
    public string $degree = "";
    public string $rank = "";
    public string $category = "";

    public function rules(): array
    {
        return [
            "experienceYears" => ["nullable", "numeric"],
            "careerStartDate" => ["nullable", "date"],
            "degree" => ["nullable", "string", "max:255"],
            "rank" => ["nullable", "string", "max:255"],
            "category" => ["nullable", "string", "max:255"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "experienceYears" => "Стаж врача",
            "careerStartDate" => "Дата начала карьеры врача",
            "degree" => "Научная степень врача",
            "rank" => "Научное звание врача",
            "category" => "Категория врача",
        ];
    }

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

        $this->experienceYears = $this->doctorInfo->experience_years;
        $this->careerStartDate = (string) $this->doctorInfo->career_start_date;
        $this->degree = (string) $this->doctorInfo->degree;
        $this->rank = (string) $this->doctorInfo->rank;
        $this->category = (string) $this->doctorInfo->category;

        $this->displayData = true;
    }

    public function update(): void
    {
        if (! $this->checkAuth()) { return; }
        $this->validate();

        $this->doctorInfo->update([
            "experience_years" => $this->experienceYears,
            "career_start_date" => $this->careerStartDate,
            "degree" => $this->degree,
            "rank" => $this->rank,
            "category" => $this->category,
        ]);

        $this->doctorInfo->refresh();
        session()->flash("doctor-info-success", "Информация успешно обновлена");
        $this->closeData();
    }

    protected function resetFields(): void
    {
        $this->reset("careerStartDate", "degree", "rank", "category", "experienceYears");
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
