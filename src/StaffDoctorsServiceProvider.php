<?php

namespace GIS\StaffDoctors;

use Illuminate\Support\ServiceProvider;

class StaffDoctorsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/staff-doctors.php', 'staff-doctors');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'sd');
    }
}
