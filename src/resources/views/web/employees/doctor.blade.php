<x-app-layout>
    @include("sd::web.employees.includes.metas")
    @include("sd::web.employees.includes.breadcrumbs")
    @include("sd::web.employees.includes.h1")

    <div class="container">
        <x-sp::employee.teaser :$employee :on-full-page="true" :is-full-page="true" />
    </div>
</x-app-layout>
