<?php

namespace GIS\StaffDoctors\Livewire\Admin\Doctors;

use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;
use GIS\StaffDoctors\Interfaces\DoctorJobInterface;
use GIS\StaffDoctors\Models\DoctorJob;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class JobsWire extends Component
{
    public DoctorInfoInterface $doctorInfo;
    public EmployeeInterface $employee;

    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $jobId = null;

    public string $organization = "";
    public string $periodYears = "";
    public string $position = "";

    public function rules(): array
    {
        return [
            "organization" => ["nullable", "string", "max:255"],
            "periodYears" => ["nullable", "string", "max:255"],
            "position" => ["nullable", "string", "max:255"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "organization" => "Организация",
            "periodYears" => "Период работы в организации",
            "position" => "Должность и специализация",
        ];
    }

    public function render(): View
    {
        $query = $this->doctorInfo->orderedJobs();
        $jobs = $query->get();
        return view("sd::livewire.admin.doctors.jobs-wire", compact("jobs"));
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth()) { return; }
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth()) { return; }
        $this->validate();

        $this->doctorInfo->jobs()->create([
            "organization" => $this->organization,
            "period_years" => $this->periodYears,
            "position" => $this->position,
        ]);

        session()->flash("doctor-jobs-success", "Работа успешно добавлена");
        $this->closeData();
    }

    public function showEdit(int $modelId): void
    {
        $this->resetFields();
        $this->jobId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }

        $this->organization = $modelObject->organization;
        $this->periodYears = $modelObject->period_years;
        $this->position = $modelObject->position;

        $this->displayData = true;
    }

    public function update(): void
    {
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }
        $this->validate();

        $modelObject->update([
            "organization" => $this->organization,
            "period_years" => $this->periodYears,
            "position" => $this->position,
        ]);

        session()->flash("doctor-jobs-success", "Работа успешно обновлена");
        $this->closeData();
    }
    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $modelId): void
    {
        $this->resetFields();
        $this->jobId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }

        try {
            $modelObject->delete();
        } catch (\Exception $exception) {
            session()->flash("doctor-jobs-error", "Ошибка при удалении работы");
            $this->closeDelete();
            return;
        }

        session()->flash("doctor-jobs-success", "Работа успешно удалена");
        $this->closeDelete();
    }

    protected function resetFields(): void
    {
        $this->reset("organization", "periodYears", "position", "jobId");
    }

    protected function findModel(): ?DoctorJobInterface
    {
        $modelClass = config("staff-doctors.customDoctorJobModel") ?? DoctorJob::class;
        $modelObject = $modelClass::find($this->jobId);
        if (! $modelObject) {
            session()->flash("doctor-jobs-error", "Работа не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $modelObject;
    }

    protected function checkAuth(): bool
    {
        try {
            $this->authorize("update", $this->employee);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("doctor-education-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
