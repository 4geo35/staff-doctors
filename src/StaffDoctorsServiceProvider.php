<?php

namespace GIS\StaffDoctors;

use GIS\ContactPage\Events\ContactDeleted;
use GIS\ContactPage\Events\ContactUpdated;
use GIS\StaffDoctors\Helpers\ClinicActionsManager;
use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffDoctors\Listeners\DisassociateClinicContactAfterDelete;
use GIS\StaffDoctors\Listeners\FreshClinicAfterContactUpdate;
use GIS\StaffDoctors\Models\Clinic;
use GIS\StaffDoctors\Models\DoctorInfo;
use GIS\StaffDoctors\Models\DoctorOffer;
use GIS\StaffDoctors\Observers\ClinicObserver;
use GIS\StaffDoctors\Observers\DoctorInfoObserver;
use GIS\StaffDoctors\Observers\DoctorOfferObserver;
use GIS\StaffDoctors\View\Components\DoctorInfoComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use GIS\StaffDoctors\Livewire\Admin\Doctors\CertificatesWire as AdminCertificatesWire;
use GIS\StaffDoctors\Livewire\Admin\Doctors\EducationWire as AdminEducationWire;
use GIS\StaffDoctors\Livewire\Admin\Doctors\InfoWire as AdminInfoWire;
use GIS\StaffDoctors\Livewire\Admin\Doctors\JobsWire as AdminJobsWire;
use GIS\StaffDoctors\Livewire\Admin\Clinics\IndexWire as AdminClinicsIndexWire;
use GIS\StaffDoctors\Livewire\Admin\DoctorServices\IndexWire as AdminDoctorServicesIndexWire;
use GIS\StaffDoctors\Livewire\Admin\DoctorOffers\IndexWire as AdminDoctorOffersIndexWire;
use GIS\StaffDoctors\Livewire\Admin\DoctorOffers\ShowWire as AdminDoctorOffersShowWire;
use GIS\StaffDoctors\Livewire\Admin\DoctorOfferPrices\ListWire as AdminDoctorOfferPricesListWire;
use Livewire\Livewire;

class StaffDoctorsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->mergeConfigFrom(__DIR__ . '/config/staff-doctors.php', 'staff-doctors');

        $this->bindInterfaces();
        $this->initFacades();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'sd');

        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->expandConfiguration();
        $this->observeModels();

        $this->listenEvents();

        $this->addLivewireComponents();
        $this->addBladeComponents();
    }

    protected function observeModels(): void
    {
        $modelClass = config("staff-doctors.customDoctorInfoModel") ?? DoctorInfo::class;
        $observerClass = config("staff-doctors.customDoctorInfoModelObserver") ?? DoctorInfoObserver::class;
        $modelClass::observe($observerClass);

        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        $observerClass = config("staff-doctors.customClinicModelObserver") ?? ClinicObserver::class;
        $modelClass::observe($observerClass);

        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        $observerClass = config("staff-doctors.customDoctorOfferModelObserver") ?? DoctorOfferObserver::class;
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

        $component = config("staff-doctors.customAdminDoctorServicesComponent");
        Livewire::component(
            "sd-admin-doctor-services",
            $component ?? AdminDoctorServicesIndexWire::class
        );

        $component = config("staff-doctors.customAdminDoctorOfferIndexComponent");
        Livewire::component(
            "sd-admin-doctor-offers",
            $component ?? AdminDoctorOffersIndexWire::class
        );

        $component = config("staff-doctors.customAdminDoctorOfferShowComponent");
        Livewire::component(
            "sd-admin-doctor-offers-show",
            $component ?? AdminDoctorOffersShowWire::class
        );

        $component = config("staff-doctors.customAdminDoctorOfferPriceListComponent");
        Livewire::component(
            "sd-admin-doctor-offer-price-list",
            $component ?? AdminDoctorOfferPricesListWire::class
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
        $permissions[] = [
            "policy" => $sd["servicePolicy"],
            "title" => $sd["servicePolicyTitle"],
            "key" => $sd["servicePolicyKey"],
        ];
        $permissions[] = [
            "policy" => $sd["offerPolicy"],
            "title" => $sd["offerPolicyTitle"],
            "key" => $sd["offerPolicyKey"],
        ];
        app()->config["user-management.permissions"] = $permissions;
    }

    protected function initFacades(): void
    {
        $this->app->singleton("clinic-actions", function () {
            $managerClass = config("staff-doctors.customClinicActionsManager") ?? ClinicActionsManager::class;
            return new $managerClass();
        });
    }

    protected function listenEvents(): void
    {
        if (config("contact-page")) {
            $listenerClass = config("staff-doctors.customFreshClinicAfterContactUpdateListener") ?? FreshClinicAfterContactUpdate::class;
            Event::listen(ContactUpdated::class, $listenerClass);

            $listenerClass = config("staff-doctors.customDisassociateClinicContactAfterDeleteListener") ?? DisassociateClinicContactAfterDelete::class;
            Event::listen(ContactDeleted::class, $listenerClass);
        }
    }

    protected function bindInterfaces(): void
    {
        $modelClass = config("staff-doctors.customDoctorOfferModel") ?? DoctorOffer::class;
        $this->app->bind(DoctorOfferInterface::class, $modelClass);
    }
}
