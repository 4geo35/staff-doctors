<?php

namespace GIS\StaffDoctors\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\StaffDoctors\Models\DoctorOffer;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DoctorOfferController extends Controller
{
    public function index(): View
    {
        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        Gate::authorize("viewAny", $modelClass);
        return view("sd::admin.doctor-offers.index");
    }
}
