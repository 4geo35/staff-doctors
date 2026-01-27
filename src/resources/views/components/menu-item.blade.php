@can("viewAny", config("staff-doctors.customClinicModel") ?? \GIS\StaffDoctors\Models\Clinic::class)
    <x-tt::admin-menu.item
        href="{{ route('admin.clinics.index') }}"
        :active="in_array(Route::currentRouteName(), ['admin.clinics.index'])">
        <x-slot name="ico"><x-sd::ico.store /></x-slot>
        Клиники
    </x-tt::admin-menu.item>
@endcan

@can("viewAny", config("staff-doctors.customDoctorServiceModel") ?? \GIS\StaffDoctors\Models\DoctorService::class)
    <x-tt::admin-menu.item
        href="{{ route('admin.doctor-services.index') }}"
        :active="in_array(Route::currentRouteName(), ['admin.doctor-services.index'])">
        <x-slot name="ico"><x-sd::ico.medical-info /></x-slot>
        Услуги
    </x-tt::admin-menu.item>
@endcan
