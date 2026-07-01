@props(["item"])
<ul class="space-y-2">
    @if ($item->doctor)
        <li>
            <div>Доктор:</div>
            <a href="{{ route('admin.employees.show', ["employee" => $item->doctor]) }}"
               class="{{ $item->doctor->published_at ? 'text-primary' : 'text-danger' }} hover:text-primary-hover text-nowrap">
                {{ $item->doctor->fio }}
            </a>
        </li>
    @endif
    @if ($item->service)
        <li>
            <div>Услуга:</div>
            <a href="{{ route("admin.doctor-services.index") }}?title={{ $item->service->title }}"
               class="text-primary hover:text-primary-hover">
                {{ $item->service->title }}
            </a>
        </li>
    @endif
    @if ($item->clinic)
        <li>
            <div>Клиника:</div>
            <a href="{{ route("admin.clinics.index") }}?name={{ $item->clinic->name }}"
               class="text-primary hover:text-primary-hover">
                {{ $item->clinic->name }}
            </a>
        </li>
    @endif
    @if ($item->department)
        <li>
            <div>Специальность (Отдел):</div>
            <a href="{{ route("admin.departments.show", ["department" => $item->department]) }}"
               class="text-primary hover:text-primary-hover">
                {{ $item->department->title }}
            </a>
        </li>
    @endif
</ul>
