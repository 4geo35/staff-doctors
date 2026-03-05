<?php

namespace GIS\StaffDoctors\Facades;

use GIS\StaffDoctors\Helpers\YmlActionsManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null getXMLContent()
 *
 * @see YmlActionsManager
 */
class YmlActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "doctor-yml-actions";
    }
}
