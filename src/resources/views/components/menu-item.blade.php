@can("viewAny", config("staff-doctors.customClinicModel") ?? \GIS\StaffDoctors\Models\Clinic::class)
    <x-tt::admin-menu.item
        href="{{ route('admin.clinics.index') }}"
        :active="in_array(Route::currentRouteName(), ['admin.clinics.index'])">
        <x-slot name="ico"><x-sd::ico.store /></x-slot>
        Клиники
    </x-tt::admin-menu.item>
@endcan
