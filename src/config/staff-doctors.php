<?php

return [
    // Models
    "customDoctorInfoModel" => null,
    "customDoctorInfoModelObserver" => null,

    "customDoctorEducationModel" => null,

    "customDoctorJobModel" => null,

    "customDoctorCertificateModel" => null,

    "customClinicModel" => null,
    "customClinicModelObserver" => null,

    "customDoctorServiceModel" => null,

    "customDoctorOfferModel" => null,
    "customDoctorOfferModelObserver" => null,

    "customDoctorOfferPriceModel" => null,

    // Controllers
    "customAdminClinicController" => null,
    "customAdminDoctorServiceController" => null,

    // Listeners
    "customFreshClinicAfterContactUpdateListener" => null,
    "customDisassociateClinicContactAfterDeleteListener" => null,

    // Facades
    "customClinicActionsManager" => null,

    // Blade components
    "customAdminBladeDoctorInfoComponent" => null,

    // Livewire components
    "customAdminDoctorInfoComponent" => null,
    "customAdminDoctorCertificatesComponent" => null,
    "customAdminDoctorEducationComponent" => null,
    "customAdminDoctorJobsComponent" => null,
    "customAdminClinicsComponent" => null,
    "customAdminDoctorServicesComponent" => null,

    // Policy
    "clinicPolicy" => \GIS\StaffDoctors\Policies\ClinicPolicy::class,
    "clinicPolicyTitle" => "Управление клиниками",
    "clinicPolicyKey" => "clinics",

    "servicePolicy" => \GIS\StaffDoctors\Policies\DoctorServicePolicy::class,
    "servicePolicyTitle" => "Управление услугами врача",
    "servicePolicyKey" => "doctor_services",
];
