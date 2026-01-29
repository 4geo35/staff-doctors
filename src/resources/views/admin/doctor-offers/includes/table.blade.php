<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Связи</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Условия</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Статус</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($offers as $item)
            <tr>
                <td>
                    <ul class="space-y-2">
                        <li>
                            <div>Доктор:</div>
                            <a href="{{ route('admin.employees.show', ["employee" => $item->doctor]) }}"
                                       class="text-primary hover:text-primary-hover text-nowrap">
                                {{ $item->doctor->fio }}
                            </a>
                        </li>
                        <li>
                            <div>Услуга:</div>
                            <a href="{{ route("admin.doctor-services.index") }}?title={{ $item->service->title }}"
                               class="text-primary hover:text-primary-hover">
                                {{ $item->service->title }}
                            </a>
                        </li>
                        <li>
                            <div>Клиника:</div>
                            <a href="{{ route("admin.clinics.index") }}?name={{ $item->clinic->name }}"
                               class="text-primary hover:text-primary-hover">
                                {{ $item->clinic->name }}
                            </a>
                        </li>
                        <li>
                            <div>Специальность (Отдел):</div>
                            <a href="{{ route("admin.departments.show", ["department" => $item->department]) }}"
                               class="text-primary hover:text-primary-hover">
                                {{ $item->department->title }}
                            </a>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul class="space-y-2">
                        <li><x-sd::bool-value :value="$item->oms">Возможность попасть на прием по полису ОМС</x-sd::bool-value></li>
                        <li><x-sd::bool-value :value="$item->appointment">Ведет ли врач прием</x-sd::bool-value></li>
                        <li><x-sd::bool-value :value="$item->children">Прием детей (до 18 лет)</x-sd::bool-value></li>
                        <li><x-sd::bool-value :value="$item->adult">Прием взрослых</x-sd::bool-value></li>
                        <li><x-sd::bool-value :value="$item->house_call">Вызов врача на дом</x-sd::bool-value></li>
                        <li><x-sd::bool-value :value="$item->telemedicine">Оказание услуги с использованием средств телемедицины</x-sd::bool-value></li>
                    </ul>
                </td>
                <td>
                    @if ($item->is_active)
                        <div class="text-success">Доступно</div>
                    @else
                        <ul class="space-y-2">
                            <li class="text-danger">Недоступно</li>
                            @if (!$item->doctor_is_active)
                                <li class="text-nowrap">Доктор не опубликован</li>
                            @endif
                            @if (! $item->price_is_active)
                                <li class="text-nowrap">Нет доступной цены</li>
                            @endif
                        </ul>
                    @endif
                </td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                                wire:loading.attr="disabled"
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit/>
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                wire:loading.attr="disabled"
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash/>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
