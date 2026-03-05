<?php

namespace GIS\StaffDoctors\Helpers;

use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffDoctors\Interfaces\DoctorServiceInterface;
use GIS\StaffDoctors\Models\DoctorOffer;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as IlluminateCollection;

class OfferActionsManager
{
    public function getSplittingByServices(EmployeeInterface $employee): IlluminateCollection
    {
        $offers = $this->getOnlyActive($employee);
        return $this->splitByServices($offers);
    }

    public function getOnlyActive(EmployeeInterface $employee = null): Collection
    {
        if (! empty($employee)) {
            $query = $employee->offers();
        } else {
            $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
            $query = $modelClass::query();
        }
        $query->with("prices", "service", "clinic", "department");

        $query->whereNotNull("published_at");
        $query->whereHas("department", fn($q) => $q->whereNotNull("published_at"));

        if (empty($employee)) {
            $query->whereHas("doctor", fn($q) => $q->whereNotNull("published_at"));
        }

        return $query->get();
    }

    protected function getServiceList(Collection $offers): IlluminateCollection
    {
        $services = [];
        foreach ($offers as $offer) {
            if (! empty($services[$offer->service_id])) { continue; }
            $services[$offer->service_id] = $offer->service;
        }
        $collection = collect(array_values($services));
        return $collection->sortBy(function (DoctorServiceInterface $service) {
            return $service->title;
        });
    }

    protected function splitByServices(Collection $offers): IlluminateCollection
    {
        $array = [];

        foreach ($offers as $offer) {
            if (empty($array[$offer->service_id])) {
                $service = $offer->service;
                $array[$offer->service_id] = (object) [
                    "id" => $service->id,
                    "slug" => $service->slug,
                    "title" => $service->title,
                    "model" => $service,
                    "offers" => [],
                ];
            }
            $array[$offer->service_id]->offers[] = $offer;
        }

        $sorted = $this->sortServices($array);
        return $this->sortOffers($sorted);
    }

    protected function sortOffers(IlluminateCollection $services): IlluminateCollection
    {
        return $services->map(function (object $service) {
            $sortedOffers = collect($service->offers)->sortBy(function (DoctorOfferInterface $offer) {
                return $offer->clinic->title;
            });
            $service->offers = $sortedOffers;
            return $service;
        });
    }

    protected function sortServices(array $services): IlluminateCollection
    {
        $collection = collect(array_values($services));
        return $collection->sortBy(function (object $service) {
            return $service->title;
        });
    }
}
