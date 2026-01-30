<?php

namespace GIS\StaffDoctors\Livewire\Admin\DoctorOffers;

use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffDoctors\Traits\OfferEditActions;
use Illuminate\View\View;
use Livewire\Component;

class ShowWire extends Component
{
    use OfferEditActions;

    public DoctorOfferInterface $offer;

    public function render(): View
    {
        return view("sd::livewire.admin.doctor-offers.show-wire");
    }
}
