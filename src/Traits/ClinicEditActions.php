<?php

namespace GIS\StaffDoctors\Traits;

use GIS\ContactPage\Models\Contact;
use GIS\StaffDoctors\Interfaces\ClinicInterface;
use GIS\StaffDoctors\Models\Clinic;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;

trait ClinicEditActions
{
    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $clinicId = null;

    public string $name = "";
    public string $address = "";
    public string $city = "";
    public string $email = "";
    public string $phone = "";
    public string $companyId = "";

    public Collection|null $contacts = null;
    public string $contactId = "";

    public function rules(): array
    {
        return [
            "name" => ["nullable", "string", "max:255"],
            "address" => ["nullable", "string", "max:255"],
            "city" => ["nullable", "string", "max:255"],
            "email" => ["nullable", "string", "max:255"],
            "phone" => ["nullable", "string", "max:255"],
            "companyId" => ["nullable", "string", "max:255"],
            "contactId" => ["nullable", "numeric", "exists:contacts,id"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Название клиники",
            "address" => "Адрес клиники",
            "city" => "Город",
            "email" => "Email",
            "phone" => "Номер телефона",
            "companyId" => "Идентификатор организации",
            "contactId" => "Контакт",
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
        $this->clinicId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth("update", $modelObject)) { return; }

        $this->name = $modelObject->name;
        $this->address = $modelObject->address;
        $this->city = $modelObject->city;
        $this->email = $modelObject->email;
        $this->phone = $modelObject->phone;
        $this->companyId = (string) $modelObject->company_id;
        $this->contactId = $modelObject->contact_id ?? "";

        $this->setContacts();
        $this->displayData = true;
    }

    public function update(): void
    {
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth("update", $modelObject)) { return; }
        $this->validate();

        $modelObject->update([
            "name" => $this->name,
            "address" => $this->address,
            "city" => $this->city,
            "email" => $this->email,
            "phone" => $this->phone,
            "company_id" => $this->companyId,
            "contact_id" => empty($this->contactId) ? null : $this->contactId,
        ]);

        session()->flash("success", "Клиника успешно обновлена");
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
        $this->clinicId = $modelId;
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

        if ($modelObject->offers()->count() > 0) {
            session()->flash("error", "Невозможно удалить клинику, есть предложения");
            $this->closeDelete();
            return;
        }

        try {
            $modelObject->delete();
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при удалении клиники");
            $this->closeDelete();
            return;
        }

        session()->flash("success", "Клиника успешно удалена");
        $this->closeDelete();
    }

    protected function setContacts(): void
    {
        if (! config("contact-page")) { return; }
        $modelClass = config("contact-page.customContactModel") ?? Contact::class;
        $this->contacts = $modelClass::query()
            ->select("title", "id", "priority", "address")
            ->orderBy("priority")
            ->get();
    }

    protected function resetFields(): void
    {
        $this->reset("clinicId", "name", "address", "city", "email", "phone", "companyId", "contacts", "contactId");
    }

    protected function checkAuth(string $action, ClinicInterface $modelObject = null): bool
    {
        try {
            $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
            $this->authorize($action, $modelObject ?? $modelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(): ?ClinicInterface
    {
        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        $modelObject = $modelClass::find($this->clinicId);
        if (! $modelObject) {
            session()->flash("error", "Клиника не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $modelObject;
    }
}
