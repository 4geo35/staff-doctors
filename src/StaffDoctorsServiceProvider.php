<?php

namespace GIS\StaffDoctors;

use GIS\StaffDoctors\Models\DoctorInfo;
use GIS\StaffDoctors\Observers\DoctorInfoObserver;
use GIS\StaffDoctors\View\Components\DoctorInfoComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use GIS\StaffDoctors\Livewire\Admin\Doctors\CertificatesWire as AdminCertificatesWire;
use GIS\StaffDoctors\Livewire\Admin\Doctors\EducationWire as AdminEducationWire;
use GIS\StaffDoctors\Livewire\Admin\Doctors\InfoWire as AdminInfoWire;
use GIS\StaffDoctors\Livewire\Admin\Doctors\JobsWire as AdminJobsWire;
use GIS\StaffDoctors\Livewire\Admin\Clinics\IndexWire as AdminClinicsIndexWire;
use Livewire\Livewire;

class StaffDoctorsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->mergeConfigFrom(__DIR__ . '/config/staff-doctors.php', 'staff-doctors');

        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'sd');

        $this->expandConfiguration();
        $this->observeModels();

        $this->addLivewireComponents();
        $this->addBladeComponents();
    }

    protected function observeModels(): void
    {
        $modelClass = config("staff-doctors.customDoctorInfoModel") ?? DoctorInfo::class;
        $observerClass = config("staff-doctors.customDoctorInfoModelObserver") ?? DoctorInfoObserver::class;
        $modelClass::observe($observerClass);
    }

    protected function addBladeComponents(): void
    {
        $component = config("staff-doctors.customAdminBladeDoctorInfoComponent") ?? DoctorInfoComponent::class;
        Blade::component("sd-admin-doctor-info", $component);
    }

    protected function addLivewireComponents(): void
    {
        $component = config("staff-doctors.customAdminDoctorInfoComponent");
        Livewire::component(
            "sd-admin-doctor-info",
            $component ?? AdminInfoWire::class
        );

        $component = config("staff-doctors.customAdminDoctorCertificatesComponent");
        Livewire::component(
            "sd-admin-doctor-certificates",
            $component ?? AdminCertificatesWire::class
        );

        $component = config("staff-doctors.customAdminDoctorEducationComponent");
        Livewire::component(
            "sd-admin-doctor-education",
            $component ?? AdminEducationWire::class
        );

        $component = config("staff-doctors.customAdminDoctorJobsComponent");
        Livewire::component(
            "sd-admin-doctor-jobs",
            $component ?? AdminJobsWire::class
        );

        $component = config("staff-doctors.customAdminClinicsComponent");
        Livewire::component(
            "sd-admin-clinics",
            $component ?? AdminClinicsIndexWire::class
        );
    }

    protected function expandConfiguration(): void
    {
        $sd = app()->config["staff-doctors"];

        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $permissions[] = [
            "policy" => $sd["clinicPolicy"],
            "title" => $sd["clinicPolicyTitle"],
            "key" => $sd["clinicPolicyKey"],
        ];
        app()->config["user-management.permissions"] = $permissions;
    }
}
