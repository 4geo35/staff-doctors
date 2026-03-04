<?php

return [
    "doctorPrefix" => "",
    "serviceQueryKey" => "service",
    "offerQueryKey" => "offer",
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

    // Listeners
    "customFreshClinicAfterContactUpdateListener" => null,
    "customDisassociateClinicContactAfterDeleteListener" => null,

    // Facades
    "customClinicActionsManager" => null,
    "customOfferActionsManager" => null,

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
];
