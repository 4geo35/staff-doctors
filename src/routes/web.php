<?php

use Illuminate\Support\Facades\Route;
use GIS\StaffDoctors\Http\Controllers\Web\EmployeeController;

Route::middleware(["web"])
    ->as("web.")
    ->group(function () {
        Route::prefix(config("staff-pages.employeePrefix"))
            ->as("employees.")
            ->group(function () {
                $controllerClass = config("staff-doctors.customWebEmployeeController") ?? EmployeeController::class;
                $url = "/{employee}";
                $prefix = config("staff-doctors.doctorPrefix");
                if (! empty($prefix)) { $url = "/{$prefix}{$url}"; }
                Route::get($url, [$controllerClass, "doctor"])->name("doctor");
            });
    });
