<?php

namespace GIS\StaffDoctors\Livewire\Web\DoctorOffers;

use GIS\RequestForm\Facades\FormActions;
use GIS\RequestForm\Interfaces\RequestFormModelInterface;
use GIS\RequestForm\Interfaces\ShouldRequestFormInterface;
use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use GIS\StaffPages\Models\EmployeeRequestRecord;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Collection as IlluminateCollection;

class MakeAppointmentWire extends Component
{
    public EmployeeInterface $employee;

    public IlluminateCollection $services;
    public object|null $firstService = null;
    public string $activeService = "";
    public string $activeOffer = "";

    public IlluminateCollection|null $offers = null;
    public DoctorOfferInterface|null $currentOffer  = null;

    public bool $displayForm = false;
    public string $uri = "";

    public string $hidden = "";

    public string $name = "";
    public string $phone = "";
    public string $comment = "";
    public bool $privacy = true;

    public function rules(): array
    {
        return FormActions::prepareValidation([
            "name" => ["required", "string", "max:50"],
            "phone" => ["required", "string", "max:18", "min:18"],
            "privacy" => ["required"],
        ]);
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Имя",
            "phone" => "Номер телефона",
            "privacy" => "Политика конфиденциальности",
        ];
    }

    public function queryString(): array
    {
        $firstService = $this->services->first();
        return [
            "activeService" => [
                "except" => $firstService?->slug,
                "as" => config("staff-doctors.serviceQueryKey")
            ],
            "activeOffer" => [
                "except" => "",
                "as" => config("staff-doctors.offerQueryKey")
            ]
        ];
    }

    public function mount(): void
    {
        $this->firstService = $this->services->first();
        if ($this->firstService) {
            if (! $this->activeService || ! $this->checkSlug($this->activeService)) {
                $this->activeService = $this->firstService->slug;
            }
        }
        $this->setOffersByActive();
        $this->uri = url()->current();
    }

    public function render(): View
    {
        return view("sd::livewire.web.doctor-offers.make-appointment-wire");
    }

    public function switchService(string $slug): void
    {
        if ($this->activeService === $slug) { return; }
        if (! $this->checkSlug($slug)) { return; }
        $this->activeService = $slug;
        $this->setOffersByActive();
    }

    #[On('show-appointment-form-by-active')]
    public function showModalByActiveOffer(): void
    {
        if (empty($this->activeOffer)) { return; }
        $id = str_replace(config("staff-doctors.offerFeedPrefix") . "_", "", $this->activeOffer);
        if (! is_numeric($id)) { return; }
        $this->showOfferModal($id);
    }

    public function closeForm(): void
    {
        $this->resetFields();
        $this->displayForm = false;
    }

    public function showOfferModal(int $offerId): void
    {
        $this->currentOffer = $this->offers->first(function ($offer) use ($offerId) {
            return $offer->id === $offerId;
        });
        if (! $this->currentOffer) { return; }
        $this->displayForm = true;
    }

    public function store(): void
    {
        $this->validate();
        try {
            $modelClass = config("staff-pages.customEmployeeRequestRecordModel") ?? EmployeeRequestRecord::class;
            $record = $modelClass::create([
                "fio" => $this->employee->fio,
                "name" => $this->name,
                "phone" => $this->phone,
                "comment" => $this->comment,
            ]);
            $record->offer()->create([
                "offer_id" => $this->currentOffer->id,
                "clinic_title" => $this->currentOffer->clinic->name,
                "service_title" => $this->currentOffer->service->title,
                "department_title" => $this->currentOffer->department->title,
                "price" => $this->currentOffer->active_price ? $this->currentOffer->active_price->price : null,
            ]);
            $form = $this->createForm($record);
            if (! $form) {
                $record->delete();
                session()->flash("error", "Ошибка при сохранении данных");
            } else {
                session()->flash("success", "Ваше обращение получено! Мы свяжемся с вами в ближайшее время.");
            }
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при сохранении данных.");
        }

        $this->resetFields();
    }

    public function resetFields(): void
    {
        $this->reset("name", "phone", "comment", "privacy");
    }

    protected function checkSlug(string $slug): bool
    {
        return (bool) $this->services->first(function ($service) use ($slug) {
            return $service->slug === $slug;
        });
    }

    protected function setOffersByActive(): void
    {
        $offers = null;
        if ($this->activeService) {
            $service = $this->services->where('slug', $this->activeService)->first();
            if ($service) { $offers = $service->offers; }
        }
        $this->offers = $offers;
    }

    protected function createForm(ShouldRequestFormInterface $record): ?RequestFormModelInterface
    {
        try {
            return $record->form()->create([
                "type" => "employee-request",
                "place" => "",
                "uri" => $this->uri,
            ]);
        } catch (\Exception $exception) {
            return null;
        }
    }
}
