<div>
    <div class="card">
        <div class="card-header">
            <div class="space-y-indent-half">
                @include("sd::admin.doctor-offers.includes.show-title")
                <x-tt::notifications.error />
                <x-tt::notifications.success />
            </div>
        </div>
        <div class="card-body">
            @include("sd::admin.doctor-offers.includes.show-body")
        </div>
    </div>

    @include("sd::admin.doctor-offers.includes.table-modals")
</div>
