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
                    @include("sd::admin.doctor-offers.includes.relation-view", compact("item"))
                </td>
                <td>
                    @include("sd::admin.doctor-offers.includes.condition-view", compact("item"))
                </td>
                <td>
                    <ul class="space-y-2">
                        @if ($item->is_active)
                            <li class="text-success">Доступно</li>
                        @else
                            <li class="text-danger">
                                Недоступно
                                @if (!$item->doctor_is_active)
                                    <div class="text-nowrap text-body text-sm">- Доктор снят с публикации</div>
                                @endif
                                @if (!$item->department_is_active)
                                    <div class="text-nowrap text-body text-sm">- Специальность (Отдел) снята с публикации</div>
                                @endif
                            </li>
                        @endif
                        @if (! $item->price_is_active)
                            <li class="text-warning">Нет доступной цены</li>
                        @endif
                    </ul>
                </td>
                <td>
                    <div class="flex justify-center">
                        @can("viewAny", $item::class)
                            <a href="{{ route("admin.doctor-offers.show", ["offer" => $item]) }}"
                               class="btn btn-primary px-btn-x-ico rounded-e-none">
                                <x-tt::ico.eye />
                            </a>
                        @else
                            <button type="button" disabled
                                    class="btn btn-primary px-btn-x-ico rounded-e-none">
                                <x-tt::ico.eye />
                            </button>
                        @endcan
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-none"
                                @can("update", $item)
                                    wire:loading.attr="disabled"
                                    wire:click="showEdit({{ $item->id }})"
                                @else
                                    disabled
                                @endif>
                            <x-tt::ico.edit/>
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @can("delete", $item)
                                    wire:loading.attr="disabled"
                                    wire:click="showDelete({{ $item->id }})"
                                @else
                                    disabled
                                @endif>
                            <x-tt::ico.trash/>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
