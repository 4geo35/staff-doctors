<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Название</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Адрес</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Город</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Email</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Телефон</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Идентификатор</x-tt::table.heading>
            @if(config("contact-page"))
                <x-tt::table.heading class="text-left text-nowrap">Контакт</x-tt::table.heading>
            @endif
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($clinics as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->city }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->company_id }}</td>
                <td>{{ $item->contact_id }}</td>
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
