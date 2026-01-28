<?php

namespace GIS\StaffDoctors\Traits;

use GIS\StaffDoctors\Interfaces\DoctorServiceInterface;
use GIS\StaffDoctors\Models\DoctorService;
use Illuminate\Auth\Access\AuthorizationException;

trait DoctorServiceEditActions
{
    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $serviceId = null;

    public string $title = "";
    public string $slug = "";
    public string $govId = "";
    public string $short = "";

    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:250"],
            "slug" => ["nullable", "string", "max:250"],
            "govId" => ["nullable", "string", "max:255"],
            "short" => ["nullable", "string", "max:255"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Наименование",
            "slug" => "Уникальный идентификатор",
            "govId" => "Код медицинской услуги",
            "short" => "Описание",
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
        $this->serviceId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth("update", $modelObject)) { return; }

        $this->title = $modelObject->title;
        $this->slug = $modelObject->slug;
        $this->govId = $modelObject->gov_id;
        $this->short = $modelObject->short;

        $this->displayData = true;
    }

    public function update(): void
    {
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth("update", $modelObject)) { return; }
        $this->validate();

        $modelObject->update([
            "title" => $this->title,
            "slug" => $this->slug,
            "gov_id" => $this->govId,
            "short" => $this->short,
        ]);

        session()->flash("success", "Услуга успешно обновлена");
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
        $this->serviceId = $modelId;
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
            session()->flash("error", "Невозможно удалить услугу, есть предложения");
            $this->closeDelete();
            return;
        }

        try {
            $modelObject->delete();
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при удалении услуги");
            $this->closeDelete();
            return;
        }

        session()->flash("success", "Услуга успешно удалена");
        $this->closeDelete();
    }

    protected function resetFields(): void
    {
        $this->reset("title", "slug", "govId", "short", "serviceId");
    }

    protected function checkAuth(string $action, DoctorServiceInterface $modelObject = null): bool
    {
        try {
            $modelClass = config("staff-doctors.customDoctorServiceModel") ?? DoctorService::class;
            $this->authorize($action, $modelObject ?? $modelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(): ?DoctorServiceInterface
    {
        $modelClass = config("staff-doctors.customDoctorServiceModel") ?? DoctorService::class;
        $modelObject = $modelClass::find($this->serviceId);
        if (! $modelObject) {
            session()->flash("error", "Услуга не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $modelObject;
    }
}
