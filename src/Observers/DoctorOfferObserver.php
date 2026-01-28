<?php

namespace GIS\StaffDoctors\Observers;

use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;

class DoctorOfferObserver
{
    public function deleted(DoctorOfferInterface $offer): void
    {
        foreach ($offer->prices as $price) {
            $price->delete();
        }
    }
}
