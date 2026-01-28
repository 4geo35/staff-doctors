<?php

namespace GIS\StaffDoctors\Livewire\Admin\Clinics;

use GIS\StaffDoctors\Models\Clinic;
use GIS\StaffDoctors\Traits\ClinicEditActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    use ClinicEditActions;

    public string $searchName = "";

    public function render(): View
    {
        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        $query = $modelClass::query();
        BuilderActions::extendLike($query, $this->searchName, "name");
        $query->orderBy("name");
        $clinics = $query->get();
        return view("sd::livewire.admin.clinics.index-wire", compact("clinics"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchName");
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }
        $this->setContacts();
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        $modelClass::query()->create([
            "name" => $this->name,
            "address" => $this->address,
            "city" => $this->city,
            "email" => $this->email,
            "phone" => $this->phone,
            "company_id" => $this->companyId,
            "contact_id" => empty($this->contactId) ? null : $this->contactId,
        ]);

        session()->flash("success", "Клиника успешно добавлена");
        $this->closeData();
    }
}
