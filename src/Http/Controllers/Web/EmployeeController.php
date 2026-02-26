<?php

namespace GIS\StaffDoctors\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GIS\Metable\Facades\MetaActions;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function doctor(EmployeeInterface $employee): View
    {
        $metas = MetaActions::renderByModel($employee);
        return view("sd::web.employees.doctor", compact("employee", "metas"));
    }
}
