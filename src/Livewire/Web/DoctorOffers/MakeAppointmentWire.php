<?php

namespace GIS\StaffDoctors\Livewire\Web\DoctorOffers;

use GIS\StaffDoctors\Facades\OfferActions;
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
    }

    public function render(): View
    {
        $offers = null;
        if ($this->activeService) {
            $service = $this->services->where('slug', $this->activeService)->first();
            if ($service) { $offers = $service->offers; }
        }
        return view("sd::livewire.web.doctor-offers.make-appointment-wire", compact("offers"));
    }

    public function switchService(string $slug): void
    {
        if ($this->activeService === $slug) { return; }
        if (! $this->checkSlug($slug)) { return; }
        $this->activeService = $slug;
    }

    public function showOfferModal(int $offerId): void
    {
        debugbar()->info($offerId);
    }

    protected function checkSlug(string $slug): bool
    {
        return (bool) $this->services->first(function ($service) use ($slug) {
            return $service->slug === $slug;
        });
    }
}
