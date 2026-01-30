<div class="card">
    <div class="card-header border-b-0">
        <div class="space-y-indent-half">
            @include("sd::admin.doctor-offer-prices.includes.title")
            <x-tt::notifications.error prefix="doctor-offer-prices-" />
            <x-tt::notifications.success prefix="doctor-offer-prices-" />
        </div>
    </div>
    @include("sd::admin.doctor-offer-prices.includes.table")
    @include("sd::admin.doctor-offer-prices.includes.table-modals")
</div>
