<div>
    <div class="card">
        <div class="card-header">
            <div class="space-y-indent-half">
                @include("sd::admin.doctors.info.title")
                <x-tt::notifications.error prefix="doctor-info-"/>
                <x-tt::notifications.success prefix="doctor-info-"/>
            </div>
        </div>
        <div class="card-body">
            @include("sd::admin.doctors.info.body")
        </div>
    </div>
    @include("sd::admin.doctors.info.modals")
</div>
