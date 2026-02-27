<?php

namespace GIS\StaffDoctors\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GIS\Metable\Facades\MetaActions;
use GIS\StaffDoctors\Facades\OfferActions;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function doctor(EmployeeInterface $employee): View
    {
        if (! $employee->published_at) { abort(404); }

        $metas = MetaActions::renderByModel($employee);
        $info = $employee->doctorInfo;
        $info->load("orderedEducation", "orderedJobs", "orderedCertificates");
        $services = OfferActions::getSplittingByServices($employee);
        return view(
            "sd::web.employees.doctor",
            compact("employee", "metas", "info", "services")
        );
    }
}
