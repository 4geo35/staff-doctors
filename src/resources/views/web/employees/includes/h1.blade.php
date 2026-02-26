@if (config("staff-pages.useH1"))
    <div class="container">
        <x-tt::h1 class="mb-indent">{{ $employee->fio }}</x-tt::h1>
    </div>
@endif
