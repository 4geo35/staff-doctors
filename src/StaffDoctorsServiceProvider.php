<?php

namespace GIS\StaffDoctors;

use GIS\StaffDoctors\Models\DoctorInfo;
use GIS\StaffDoctors\Observers\DoctorInfoObserver;
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

        $this->observeModels();
    }

    protected function observeModels(): void
    {
        $modelClass = config("staff-doctors.customDoctorInfoModel") ?? DoctorInfo::class;
        $observerClass = config("staff-doctors.customDoctorInfoModelObserver") ?? DoctorInfoObserver::class;
        $modelClass::observe($observerClass);
    }
}
