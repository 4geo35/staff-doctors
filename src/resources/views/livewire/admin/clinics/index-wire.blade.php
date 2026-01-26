<div class="card">
    <div class="card-body">
        <div class="space-y-indent-half">
            @include("sd::admin.clinics.includes.search")
            <x-tt::notifications.error />
            <x-tt::notifications.success />
        </div>
    </div>
    @include("sd::admin.clinics.includes.table")
    @include("sd::admin.clinics.includes.table-modals")
</div>
