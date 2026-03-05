<?php

return [
    "doctorPrefix" => "",
    "serviceQueryKey" => "service",
    "offerQueryKey" => "offer",
    "appointmentBlockId" => "make-appointment",

    // YML
    "ymlCacheKey" => "doctor-yml-export",
    "ymlCacheLifetime" => env("DOCTOR_YML_CACHE_LIFETIME", 86400),
    "ymlPrefix" => "doctor-export",
    "ymlName" => env("DOCTOR_YML_NAME", ""),
    "ymlCompany" => env("DOCTOR_YML_COMPANY", ""),
    "ymlPicture" => env("DOCTOR_YML_PICTURE", "favicon.ico"),
    "ymlEmail" => env("DOCTOR_YML_EMAIL", ""),
    "clinicFeedPrefix" => "clinic",
    "offerFeedPrefix" => "offer",

    // Btn text
    "teaserBtnTitle" => "Подробнее",

    // Forms
    "customOfferRequestRecordModel" => null,
    "customAdminOfferFormTableComponent" => null,

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
    "customAdminDoctorOfferController" => null,

    "customWebEmployeeController" => null,
    "customExportDoctorController" => null,

    // Listeners
    "customFreshClinicAfterContactUpdateListener" => null,
    "customDisassociateClinicContactAfterDeleteListener" => null,

    // Facades
    "customClinicActionsManager" => null,
    "customOfferActionsManager" => null,
    "customYmlActionsManager" => null,

    // Blade components
    "customAdminBladeDoctorInfoComponent" => null,

    // Livewire components
    "customAdminDoctorInfoComponent" => null,
    "customAdminDoctorCertificatesComponent" => null,
    "customAdminDoctorEducationComponent" => null,
    "customAdminDoctorJobsComponent" => null,
    "customAdminClinicsComponent" => null,
    "customAdminDoctorServicesComponent" => null,
    "customAdminDoctorOfferIndexComponent" => null,
    "customAdminDoctorOfferShowComponent" => null,
    "customAdminDoctorOfferPriceListComponent" => null,

    "customWebDoctorOfferMakeAppointmentComponent" => null,

    // Policy
    "clinicPolicy" => \GIS\StaffDoctors\Policies\ClinicPolicy::class,
    "clinicPolicyTitle" => "Управление клиниками",
    "clinicPolicyKey" => "clinics",

    "servicePolicy" => \GIS\StaffDoctors\Policies\DoctorServicePolicy::class,
    "servicePolicyTitle" => "Управление услугами врача",
    "servicePolicyKey" => "doctor_services",

    "offerPolicy" => \GIS\StaffDoctors\Policies\DoctorOfferPolicy::class,
    "offerPolicyTitle" => "Управление предложениями врачей",
    "offerPolicyKey" => "doctor_offers",

    // Templates
    "templates" => [
        "doctor-yml" => \GIS\StaffDoctors\Templates\DoctorYml::class,
    ],
];
