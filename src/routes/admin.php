<?php

use Illuminate\Support\Facades\Route;
use GIS\StaffDoctors\Http\Controllers\Admin\ClinicController;
use GIS\StaffDoctors\Http\Controllers\Admin\DoctorServiceController;
use GIS\StaffDoctors\Http\Controllers\Admin\DoctorOfferController;

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

        Route::prefix("doctor-services")
            ->as("doctor-services.")
            ->group(function () {
                $controllerClass = config("staff-doctors.customAdminDoctorServiceController") ?? DoctorServiceController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
            });

        Route::prefix("doctor-offers")
            ->as("doctor-offers.")
            ->group(function () {
                $controllerClass = config("staff-doctors.customAdminDoctorOfferController") ?? DoctorOfferController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
            });
    });
