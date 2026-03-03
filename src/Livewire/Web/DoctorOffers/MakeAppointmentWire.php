<?php

namespace GIS\StaffDoctors\Livewire\Web\DoctorOffers;

use GIS\RequestForm\Interfaces\RequestFormModelInterface;
use GIS\RequestForm\Interfaces\ShouldRequestFormInterface;
use GIS\StaffDoctors\Facades\OfferActions;
use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Collection as IlluminateCollection;

class MakeAppointmentWire extends Component
{
    public EmployeeInterface $employee;

    public IlluminateCollection $services;
    public object|null $firstService = null;
    public string $activeService = "";

    public IlluminateCollection|null $offers = null;
    public DoctorOfferInterface|null $currentOffer  = null;

    public bool $displayForm = false;
    public string $uri = "";

    public string $hidden = "";

    public string $name = "";
    public string $phone = "";
    public string $comment = "";
    public bool $privacy = true;

    public function queryString(): array
    {
        $firstService = $this->services->first();
        return [
            "activeService" => [
                "except" => $firstService?->slug,
                "as" => config("staff-doctors.serviceQueryKey")
            ],
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

    public function showOfferModal(int $offerId): void
    {
        $this->currentOffer = $this->offers->first(function ($offer) use ($offerId) {
            return $offer->id === $offerId;
        });
        if (! $this->currentOffer) { return; }
        $this->displayForm = true;
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
