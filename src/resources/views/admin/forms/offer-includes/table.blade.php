<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">ID</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap"
                                 sortable direction="{{ $orderBy == 'name' ? $orderByDirection : '' }}"
                                 wire:click="changeOrder('name')">
                Имя
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap"
                                 sortable direction="{{ $orderBy == 'phone' ? $orderByDirection : '' }}"
                                 wire:click="changeOrder('phone')">
                Телефон
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap"
                                 sortable direction="{{ $orderBy == 'fio' ? $orderByDirection : '' }}"
                                 wire:click="changeOrder('fio')">
                Предложение
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Комментарий</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap"
                                 sortable direction="{{ $orderBy == 'created' ? $orderByDirection : '' }}"
                                 wire:click="changeOrder('created')">
                Отправление
            </x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($forms as $item)
            <tr>
                <td class="text-nowrap">{{ $item->id }}</td>
                <td class="text-nowrap">{{ $item->recordable->name }}</td>
                <td class="text-nowrap">{{ $item->recordable->phone }}</td>
                <td class="">
                    @include("sd::admin.forms.offer-includes.offer-info")
                </td>
                <td class="">{{ $item->recordable->comment }}</td>
                <td>
                    @include("rf::admin.forms.includes.info")
                </td>
                <td>
                    @include("rf::admin.forms.includes.actions")
                </td>
            </tr>
        @endforeach
    </x-slot>
    <x-slot name="caption">
        <div class="flex justify-between">
            <div>{{ __("Total") }}: {{ $forms->total() }}</div>
            {{ $forms->links("tt::pagination.live") }}
        </div>
    </x-slot>
</x-tt::table>
