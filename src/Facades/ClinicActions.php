<?php

namespace GIS\StaffDoctors\Facades;

use GIS\StaffDoctors\Helpers\ClinicActionsManager;
use GIS\StaffDoctors\Interfaces\ClinicInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void setValuesFromContact(ClinicInterface $clinic)
 * @method static Collection|null findClinicsByContactId(int $contactId)
 *
 * @see ClinicActionsManager
 */
class ClinicActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "clinic-actions";
    }
}
