<div class="row">
    <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
        @include("sd::admin.doctor-offers.includes.relation-view", ["item" => $offer])
    </div>

    <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
        @include("sd::admin.doctor-offers.includes.condition-view", ["item" => $offer])
    </div>
</div>
