<?php

return [
    // Admin
    "customDoctorInfoModel" => null,
    "customDoctorInfoModelObserver" => null,

    "customDoctorEducationModel" => null,

    "customDoctorJobModel" => null,

    "customDoctorCertificateModel" => null,

    "customClinicModel" => null,

    // Blade components
    "customAdminBladeDoctorInfoComponent" => null,

    // Livewire components
    "customAdminDoctorInfoComponent" => null,
    "customAdminDoctorCertificatesComponent" => null,
    "customAdminDoctorEducationComponent" => null,
    "customAdminDoctorJobsComponent" => null,

    // Policy
    "clinicPolicy" => \GIS\StaffDoctors\Policies\ClinicPolicy::class,
    "clinicPolicyTitle" => "Управление клиниками",
    "clinicPolicyKey" => "clinics",
];
