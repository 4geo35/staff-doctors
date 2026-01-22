<div class="card">
    <div class="card-header border-b-0">
        <div class="space-y-indent-half">
            @include("sd::admin.doctors.certificates.title")
            <x-tt::notifications.error prefix="doctor-certificates-" />
            <x-tt::notifications.success prefix="doctor-certificates-" />
        </div>
    </div>
    @include("sd::admin.doctors.certificates.table")
    @include("sd::admin.doctors.certificates.table-modals")
</div>
