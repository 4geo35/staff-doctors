<div>
    <div class="card">
        <div class="card-body">
            <div class="space-y-indent-half">
                @include("sd::admin.doctor-offers.includes.search")
                <x-tt::notifications.error />
                <x-tt::notifications.success />
            </div>
        </div>
        @include("sd::admin.doctor-offers.includes.table")
        @include("sd::admin.doctor-offers.includes.table-modals")
    </div>
</div>
