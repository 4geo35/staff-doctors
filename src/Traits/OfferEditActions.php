<?php

namespace GIS\StaffDoctors\Traits;

use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffDoctors\Models\Clinic;
use GIS\StaffDoctors\Models\DoctorOffer;
use GIS\StaffDoctors\Models\DoctorService;
use GIS\StaffPages\Models\Employee;
use GIS\StaffPages\Models\EmployeeDepartment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;

trait OfferEditActions
{
    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $offerId = null;

    public int|null $serviceId = null;
    public int|null $clinicId = null;
    public int|null $doctorId = null;
    public int|null $departmentId = null;

    public bool $oms = false;
    public bool $appointment = false;
    public bool $children = false;
    public bool $adult = false;
    public bool $houseCall = false;
    public bool $telemedicine = false;
    public bool $isBaseService = false;

    public Collection|null $serviceList = null;
    public Collection|null $clinicList = null;
    public Collection|null $doctorList = null;
    public Collection|null $departmentList = null;

    public function rules(): array
    {
        return [
            "doctorId" => ["required", "integer", "exists:employees,id"],
            "clinicId" => ["required", "integer", "exists:clinics,id"],
            "serviceId" => ["required", "integer", "exists:doctor_services,id"],
            "departmentId" => ["required", "integer", "exists:employee_departments,id"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "doctorId" => "Врач",
            "clinicId" => "Клиника",
            "serviceId" => "Услуга",
            "departmentId" => "Специальность (Отдел)",
        ];
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showEdit(int $modelId): void
    {
        $this->resetFields();
        $this->offerId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth("update", $modelObject)) { return; }

        $this->setServiceList();
        $this->setClinicList();
        $this->setDoctorList();
        $this->setDepartmentList();

        $this->doctorId = $modelObject->doctor_id;
        $this->serviceId = $modelObject->service_id;
        $this->clinicId = $modelObject->clinic_id;
        $this->departmentId = $modelObject->department_id;

        $this->oms = (bool) $modelObject->oms;
        $this->appointment = (bool) $modelObject->appointment;
        $this->children = (bool) $modelObject->children;
        $this->adult = (bool) $modelObject->adult;
        $this->houseCall = (bool) $modelObject->house_call;
        $this->telemedicine = (bool) $modelObject->telemedicine;
        $this->isBaseService = (bool) $modelObject->is_base_service;

        $this->displayData = true;
    }

    public function update(): void
    {
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth("update", $modelObject)) { return; }
        $this->validate();

        $modelObject->update([
            "doctor_id" => $this->doctorId,
            "service_id" => $this->serviceId,
            "clinic_id" => $this->clinicId,
            "department_id" => $this->departmentId,

            "oms" => $this->oms ? now() : null,
            "appointment" => $this->appointment ? now() : null,
            "children" => $this->children ? now() : null,
            "adult" => $this->adult ? now() : null,
            "house_call" => $this->houseCall ? now() : null,
            "telemedicine" => $this->telemedicine ? now() : null,
            "is_base_service" => $this->isBaseService ? now() : null,
        ]);

        session()->flash("success", "Предложение успешно обновлено");
        $this->closeData();
        if (isset($this->offer)) { $this->offer = $modelObject; }
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $modelId): void
    {
        $this->resetFields();
        $this->offerId = $modelId;
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
            session()->flash("error", "Ошибка при удалении предложения");
            $this->closeDelete();
            return;
        }

        session()->flash("success", "Предложение успешно удалено");
        $this->closeDelete();
        if (isset($this->offer)) { $this->redirectRoute("admin.doctor-offers.index"); }
    }

    protected function setServiceList(): void
    {
        $modelClass = config("staff-doctors.customDoctorServiceModel") ?? DoctorService::class;
        $this->serviceList = $modelClass::query()
            ->select("id", "title")
            ->orderBy("title")
            ->get();
    }

    protected function setClinicList(): void
    {
        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        $this->clinicList = $modelClass::query()
            ->select("id", "name")
            ->orderBy("name")
            ->get();
    }

    protected function setDoctorList(): void
    {
        $modelClass = config("staff-pages.customEmployeeModel") ?? Employee::class;
        $this->doctorList = $modelClass::query()
            ->select("id", "last_name", "name", "patronymic")
            ->orderBy("last_name")
            ->get();
    }

    protected function setDepartmentList(): void
    {
        $modelClass = config("staff-pages.customDepartmentModel") ?? EmployeeDepartment::class;
        $this->departmentList = $modelClass::query()
            ->select("id", "title")
            ->orderBy("title")
            ->get();
    }

    protected function resetFields(): void
    {
        $this->reset(
            "doctorId", "clinicId", "serviceId", "departmentId",
            "oms", "appointment", "children", "adult", "houseCall", "telemedicine", "isBaseService",
            "offerId"
        );
    }

    protected function checkAuth(string $action, DoctorOfferInterface $modelObject = null): bool
    {
        try {
            $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
            $this->authorize($action, $modelObject ?? $modelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(): ?DoctorOfferInterface
    {
        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        $modelObject = $modelClass::find($this->offerId);
        if (! $modelObject) {
            session()->flash("error", "Предложение не найдено");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $modelObject;
    }
}
