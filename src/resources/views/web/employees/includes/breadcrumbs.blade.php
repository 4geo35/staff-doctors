@if (config("staff-pages.useBreadcrumbs"))
    @php($homeUrl = \Illuminate\Support\Facades\Route::has("web.home") ? route("web.home") : "/")
    <x-tt::breadcrumbs>
        <x-tt::breadcrumbs.item :url="$homeUrl">Главная</x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item :url="route('web.employees.index')">
            {{ config("staff-pages.employeePageTitle") }}
        </x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item>{{ $employee->fio }}</x-tt::breadcrumbs.item>
    </x-tt::breadcrumbs>
@endif
