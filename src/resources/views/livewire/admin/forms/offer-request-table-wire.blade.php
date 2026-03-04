<div class="card">
    <div class="card-body">
        <div class="space-y-indent-half">
            @include("sd::admin.forms.offer-includes.search")
            <x-tt::notifications.error />
            <x-tt::notifications.success />
        </div>
    </div>

    @include("sd::admin.forms.offer-includes.table")
    @include("rf::admin.forms.includes.delete-modal")
</div>
