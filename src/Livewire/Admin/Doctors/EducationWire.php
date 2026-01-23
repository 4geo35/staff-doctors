<?php

namespace GIS\StaffDoctors\Livewire\Admin\Doctors;

use GIS\StaffDoctors\Interfaces\DoctorEducationInterface;
use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;
use GIS\StaffDoctors\Models\DoctorEducation;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class EducationWire extends Component
{
    public DoctorInfoInterface $doctorInfo;
    public EmployeeInterface $employee;

    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $educationId = null;

    public string $organization = "";
    public int|null $finishYear = null;
    public string $type = "";
    public string $specialization = "";

    public function rules(): array
    {
        return [
            "organization" => ["nullable", "string", "max:255"],
            "finishYear" => ["nullable", "numeric"],
            "type" => ["nullable", "string", "max:255"],
            "specialization" => ["nullable", "string", "max:255"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "organization" => "Образовательное учреждение",
            "finishYear" => "Год окончания обучения",
            "type" => "Уровень образования",
            "specialization" => "Специализация",
        ];
    }

    public function render(): View
    {
        $query = $this->doctorInfo->orderedEducation();
        $education = $query->get();
        return view("sd::livewire.admin.doctors.education-wire", compact("education"));
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

        $this->doctorInfo->education()->create([
            "organization" => $this->organization,
            "finish_year" => $this->finishYear,
            "type" => $this->type,
            "specialization" => $this->specialization,
        ]);

        session()->flash("doctor-education-success", "Образование успешно добавлено");
        $this->closeData();
    }

    public function showEdit(int $modelId): void
    {
        $this->resetFields();
        $this->educationId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }

        $this->organization = $modelObject->organization;
        $this->finishYear = $modelObject->finish_year;
        $this->type = $modelObject->type;
        $this->specialization = $modelObject->specialization;

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
            "finish_year" => $this->finishYear,
            "type" => $this->type,
            "specialization" => $this->specialization,
        ]);

        session()->flash("doctor-education-success", "Образование успешно обновлено");
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
        $this->educationId = $modelId;
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
            session()->flash("doctor-education-error", "Ошибка при удалении образования");
            $this->closeDelete();
            return;
        }

        session()->flash("doctor-education-success", "Образование успешно удалено");
        $this->closeDelete();
    }

    protected function resetFields(): void
    {
        $this->reset("organization", "finishYear", "type", "specialization", "educationId");
    }

    protected function findModel(): ?DoctorEducationInterface
    {
        $modelClass = config("staff-doctors.customDoctorEducationModel") ?? DoctorEducation::class;
        $modelObject = $modelClass::find($this->educationId);
        if (! $modelObject) {
            session()->flash("doctor-education-error", "Образование не найдено");
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
