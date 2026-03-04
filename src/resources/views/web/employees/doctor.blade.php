<x-app-layout>
    @include("sd::web.employees.includes.metas")
    @include("sd::web.employees.includes.breadcrumbs")
    @include("sd::web.employees.includes.h1")

    <div class="container mb-indent-lg">
        <x-sp::employee.teaser :$employee :on-full-page="true" :is-full-page="true" anchor="make-appointment" />
    </div>

    <div class="container">
        <div class="row">
            <div class="col w-full xl:w-10/12 2xl:w-2/3 mx-auto">
                @include("sd::web.employees.includes.info.expanded")
                @include("sd::web.employees.includes.info.education")
                @include("sd::web.employees.includes.info.jobs")
                @include("sd::web.employees.includes.info.certificates")
                @if ($services->count())
                    <livewire:sd-web-make-appointment :$employee :$services />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
