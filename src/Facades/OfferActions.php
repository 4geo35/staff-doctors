<?php

namespace GIS\StaffDoctors\Facades;

use GIS\StaffDoctors\Helpers\OfferActionsManager;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\Support\Collection as IlluminateCollection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static IlluminateCollection getSplittingByServices(EmployeeInterface $employee)
 *
 * @see OfferActionsManager
 */
class OfferActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "doctor-offer-actions";
    }
}
