<?php

use Illuminate\Support\Facades\Route;
use GIS\StaffDoctors\Http\Controllers\Export\DoctorController;

Route::middleware(["web"])
    ->as("export.")
    ->group(function () {
        Route::prefix(config("staff-doctors.ymlPrefix"))
            ->as("doctors.")
            ->group(function () {
                $controllerClass = config("staff-doctors.customExportDoctorController") ?? DoctorController::class;
                Route::get("/yml", [$controllerClass, "yml"])->name("yml");
            });
    });
