<div class="card">
    <div class="card-header border-b-0">
        <div class="space-y-indent-half">
            @include("sd::admin.doctors.education.title")
            <x-tt::notifications.error prefix="doctor-education-" />
            <x-tt::notifications.success prefix="doctor-education-" />
        </div>
    </div>
    @include("sd::admin.doctors.education.table")
    @include("sd::admin.doctors.education.table-modals")
</div>
