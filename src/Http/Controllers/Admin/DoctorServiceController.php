<?php

namespace GIS\StaffDoctors\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\StaffDoctors\Models\Clinic;
use GIS\StaffDoctors\Models\DoctorService;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DoctorServiceController extends Controller
{
    public function index(): View
    {
        $modelClass = config("staff-doctors.customDoctorServiceModel") ?? DoctorService::class;
        Gate::authorize("viewAny", $modelClass);
        return view("sd::admin.doctor-services.index");
    }
}
