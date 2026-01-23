<div class="card">
    <div class="card-header border-b-0">
        <div class="space-y-indent-half">
            @include("sd::admin.doctors.jobs.title")
            <x-tt::notifications.error prefix="doctor-jobs-" />
            <x-tt::notifications.success prefix="doctor-jobs-" />
        </div>
    </div>
    @include("sd::admin.doctors.jobs.table")
    @include("sd::admin.doctors.jobs.table-modals")
</div>
