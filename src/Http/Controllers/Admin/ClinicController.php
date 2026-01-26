<?php

namespace GIS\StaffDoctors\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\StaffDoctors\Models\Clinic;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ClinicController extends Controller
{
    public function index(): View
    {
        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        Gate::authorize("viewAny", $modelClass);
        return view("sd::admin.clinics.index");
    }
}
