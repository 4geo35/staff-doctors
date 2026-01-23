<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Образовательное учреждение</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Год окончания обучения</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Уровень образования</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Специализация</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($education as $item)
            <tr>
                <td>{{ $item->organization }}</td>
                <td>{{ $item->finish_year }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->specialization }}</td>
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
