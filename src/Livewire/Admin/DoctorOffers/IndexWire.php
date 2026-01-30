<?php

namespace GIS\StaffDoctors\Livewire\Admin\DoctorOffers;

use GIS\StaffDoctors\Models\DoctorOffer;
use GIS\StaffDoctors\Traits\OfferEditActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    use OfferEditActions;

    public string $searchLastName = '';
    public string $searchServiceTitle = "";
    public string $searchClinicName = "";
    public string $searchDepartmentTitle = "";

    public function render(): View
    {
        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        $query = $modelClass::query();
        $query->with("prices", "doctor", "service", "clinic", "department");
        BuilderActions::extendRelationLike($query, $this->searchLastName, "last_name", "doctor");
        BuilderActions::extendRelationLike($query, $this->searchServiceTitle, "title", "service");
        BuilderActions::extendRelationLike($query, $this->searchClinicName, "name", "clinic");
        BuilderActions::extendRelationLike($query, $this->searchDepartmentTitle, "title", "department");
        $query->orderBy("created_at", "DESC");
        $offers = $query->get();
        return view("sd::livewire.admin.doctor-offers.index-wire", compact("offers"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchLastName", "searchServiceTitle", "searchClinicName", "searchDepartmentTitle");
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }

        $this->setServiceList();
        $this->setClinicList();
        $this->setDoctorList();
        $this->setDepartmentList();

        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        $modelClass::query()->create([
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

        session()->flash("success", "Предложение успешно добавлено");
        $this->closeData();
    }
}
