<?php

namespace GIS\StaffDoctors\Livewire\Admin\DoctorServices;

use GIS\StaffDoctors\Models\DoctorService;
use GIS\StaffDoctors\Traits\DoctorServiceEditActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    use DoctorServiceEditActions;

    public string $searchTitle = "";

    public function render(): View
    {
        $modelClass = config("staff-doctors.customDoctorServiceModel") ?? DoctorService::class;
        $query = $modelClass::query();
        BuilderActions::extendLike($query, $this->searchTitle, "title");
        $query->orderBy("title");
        $services = $query->get();
        return view("sd::livewire.admin.doctor-services.index-wire", compact("services"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchTitle");
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

        $modelClass = config("staff-doctors.customDoctorServiceModel") ?? DoctorService::class;
        $modelClass::query()->create([
            "title" => $this->title,
            "slug" => $this->slug,
            "gov_id" => $this->govId,
            "short" => $this->short,
        ]);

        session()->flash("success", "Услуга успешно добавлена");
        $this->closeData();
    }
}
