<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Цена</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Скидка</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Условия для скидки</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Условия бесплатного приема</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($prices as $item)
            <tr>
                <td>{{ $item->price }}</td>
                <td>{{ $item->discount }}</td>
                <td>{{ $item->discount_condition }}</td>
                <td>{{ $item->free_condition }}</td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                                @cannot("update", $offer) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit/>
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @cannot("update", $offer) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash/>
                        </button>

                        <button type="button"
                                class="btn {{ $item->published_at ? 'btn-success' : 'btn-danger' }} px-btn-x-ico ml-indent-half"
                                @cannot("update", $offer) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="switchPublish({{ $item->id }})">
                            @if ($item->published_at)
                                <x-tt::ico.toggle-on/>
                            @else
                                <x-tt::ico.toggle-off/>
                            @endif
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
