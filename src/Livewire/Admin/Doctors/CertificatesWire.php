<?php

namespace GIS\StaffDoctors\Livewire\Admin\Doctors;

use GIS\StaffDoctors\Interfaces\DoctorCertificateInterface;
use GIS\StaffDoctors\Interfaces\DoctorInfoInterface;
use GIS\StaffDoctors\Models\DoctorCertificate;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class CertificatesWire extends Component
{
    public DoctorInfoInterface $doctorInfo;
    public EmployeeInterface $employee;

    public bool $displayData = false;
    public bool $displayDelete = false;
    public int|null $certificateId = null;

    public string $organization = "";
    public int|null $finishYear = null;
    public string $name = "";

    public function rules(): array
    {
        return [
            "organization" => ["nullable", "string", "max:255"],
            "finishYear" => ["nullable", "numeric"],
            "name" => ["nullable", "string", "max:255"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "organization" => "Организация",
            "finishYear" => "Год выдачи сертификата",
            "name" => "Название сертификата",
        ];
    }

    public function render(): View
    {
        $query = $this->doctorInfo->certificates();
        $certificates = $query->get();
        return view("sd::livewire.admin.doctors.certificates-wire", compact("certificates"));
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $this->doctorInfo->certificates()->create([
            "organization" => $this->organization,
            "finish_year" => $this->finishYear,
            "name" => $this->name,
        ]);

        session()->flash("doctor-certificates-success", "Сертификат успешно добавлен");
        $this->closeData();
    }

    public function showEdit(int $certificateId): void
    {
        $this->resetFields();
        $this->certificateId = $certificateId;
        $certificate = $this->findModel();
        if (! $certificate) { return; }
        if (! $this->checkAuth("update", $certificate)) { return; }

        $this->organization = $certificate->organization;
        $this->finishYear = $certificate->finish_year;
        $this->name = $certificate->name;

        $this->displayData = true;
    }

    public function update(): void
    {
        $certificate = $this->findModel();
        if (! $certificate) { return; }
        if (! $this->checkAuth("update", $certificate)) { return; }
        $this->validate();

        $certificate->update([
            "organization" => $this->organization,
            "finish_year" => $this->finishYear,
            "name" => $this->name,
        ]);

        session()->flash("doctor-certificates-success", "Сертификат успешно обновлен");
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
        $this->certificateId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth("delete", $modelObject)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth("delete", $modelObject)) { return; }

        try {
            $modelObject->delete();
        } catch (\Exception $exception) {
            session()->flash("doctor-certificates-error", "Ошибка при удалении сертификата");
            $this->closeDelete();
            return;
        }

        session()->flash("doctor-certificates-success", "Сертификат успешно удален");
        $this->closeDelete();
    }

    protected function resetFields(): void
    {
        $this->reset("certificateId", "organization", "finishYear", "name");
    }

    protected function checkAuth(string $action, DoctorCertificateInterface $certificate = null): bool
    {
        try {
            $modelClass = config("staff-doctors.customDoctorCertificateModel") ?? DoctorCertificate::class;
            $this->authorize($action, $certificate ?? $modelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("doctor-certificates-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(): ?DoctorCertificateInterface
    {
        $modelClass = config("staff-doctors.customDoctorCertificateModel") ?? DoctorCertificate::class;
        $certificate = $modelClass::find($this->certificateId);
        if (! $certificate) {
            session()->flash("doctor-certificates-error", "Сертификат не найден");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $certificate;
    }
}
