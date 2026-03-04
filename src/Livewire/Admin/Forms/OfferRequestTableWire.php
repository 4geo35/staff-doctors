<?php

namespace GIS\StaffDoctors\Livewire\Admin\Forms;

use GIS\RequestForm\Models\RequestForm;
use GIS\RequestForm\Traits\FormPageActionsTrait;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class OfferRequestTableWire extends Component
{
    use FormPageActionsTrait, WithPagination;

    public string $searchName = "";
    public string $searchPhone = "";
    public string $searchFio = "";
    public string $searchFrom = "";
    public string $searchTo = "";

    public string $searchUri = "";
    public string $searchPlace = "";
    public string $searchIp = "";
    public string $searchId = "";

    public string $searchClinic = "";
    public string $searchService = "";
    public string $searchDepartment = "";

    protected function queryString(): array
    {
        return [
            "searchName" => ["as" => "name", "except" => ""],
            "searchPhone" => ["as" => "phone", "except" => ""],
            "searchFio" => ["as" => "fio", "except" => ""],
            "searchFrom" => ["as" => "from", "except" => ""],
            "searchTo" => ["as" => "to", "except" => ""],

            "searchUri" => ["as" => "uri", "except" => ""],
            "searchPlace" => ["as" => "place", "except" => ""],
            "searchIp" => ["as" => "ip", "except" => ""],
            "searchId" => ["as" => "id", "except" => ""],

            "searchClinic" => ["as" => "clinic", "except" => ""],
            "searchService" => ["as" => "service", "except" => ""],
            "searchDepartment" => ["as" => "department", "except" => ""],

            "orderBy" => ["as" => "order-by", "except" => ""],
            "orderByDirection" => ["as" => "direction", "except" => ""],
        ];
    }

    public function render(): View
    {
        $formModelClass = config("request-form.customRequestFormModel") ?? RequestForm::class;
        $query = $formModelClass::query();
        $query
            ->select("request_forms.*")
            ->leftJoin("employee_request_records", "employee_request_records.id", "=", "request_forms.recordable_id")
            ->leftJoin("offer_request_records", "offer_request_records.employee_request_id", "=", "employee_request_records.id")
            ->with(["recordable" => function ($query) { $query->with("offer"); }, "user"])
            ->where("request_forms.type", "employee-request");

        BuilderActions::extendLike($query, $this->searchName, "employee_request_records.name");
        BuilderActions::extendLike($query, $this->searchPhone, "employee_request_records.phone");
        BuilderActions::extendLike($query, $this->searchFio, "employee_request_records.fio");
        BuilderActions::extendDate($query, $this->searchFrom, $this->searchTo, "request_forms.created_at");

        BuilderActions::extendLike($query, $this->searchUri, "request_forms.uri");
        BuilderActions::extendLike($query, $this->searchPlace, "request_forms.place");
        BuilderActions::extendLike($query, $this->searchIp, "request_forms.ip_address");
        BuilderActions::extendLike($query, $this->searchId, "request_forms.id");

        BuilderActions::extendLike($query, $this->searchClinic, "offer_request_records.clinic_title");
        BuilderActions::extendLike($query, $this->searchService, "offer_request_records.service_title");
        BuilderActions::extendLike($query, $this->searchDepartment, "offer_request_records.department_title");

        if ($this->orderBy === "created") {
            $orderBy = "request_forms.created_at";
        } else {
            $orderBy = "employee_request_records.{$this->orderBy}";
        }
        $query->orderBy($orderBy, $this->orderByDirection);

        $forms = $query->paginate();

        return view("sd::livewire.admin.forms.offer-request-table-wire", compact("forms"));
    }

    public function clearSearch(): void
    {
        $this->reset(
            "searchName", "searchPhone", "searchFio", "searchFrom", "searchTo",
            "searchUri", "searchPlace", "searchIp", "searchId",
            "searchClinic", "searchService", "searchDepartment",
            "orderBy", "orderByDirection",
        );
        $this->resetPage();
    }
}
