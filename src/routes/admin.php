<?php

use Illuminate\Support\Facades\Route;
use GIS\StaffDoctors\Http\Controllers\Admin\ClinicController;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::prefix("clinics")
            ->as("clinics.")
            ->group(function () {
                $controllerClass = config("staff-doctors.customAdminClinicController") ?? ClinicController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
            });
    });
