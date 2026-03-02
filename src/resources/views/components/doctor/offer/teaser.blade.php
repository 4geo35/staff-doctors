@props(["offer"])
<div class="flex flex-col h-full p-indent border border-stroke rounded-base space-y-indent">
    <div class="flex-auto">
        <div class="mb-indent">
            <x-tt::h3>{{ $offer->clinic->name }}</x-tt::h3>
            @if ($offer->clinic->address)
                <div class="mt-indent-xs text-lg font-semibold">{{ $offer->clinic->address }}</div>
            @endif
        </div>
        <div class="inline-flex items-center justify-center h-7.5 px-indent-xs mb-indent bg-light rounded-base text-sm font-medium">
            {{ $offer->department->title }}
        </div>
        <div class="space-y-indent-xs">
            <x-sd::doctor.offer.value :value="$offer->oms">Прием по полису ОМС</x-sd::doctor.offer.value>
            <x-sd::doctor.offer.value :value="$offer->appointment">Ведет ли врач прием</x-sd::doctor.offer.value>
            <x-sd::doctor.offer.value :value="$offer->children">Прием детей (до 18 лет)</x-sd::doctor.offer.value>
            <x-sd::doctor.offer.value :value="$offer->adult">Прием взрослых</x-sd::doctor.offer.value>
            <x-sd::doctor.offer.value :value="$offer->house_call">Вызов врача на дом</x-sd::doctor.offer.value>
            <x-sd::doctor.offer.value :value="$offer->telemedicine">Оказание услуги с использованием средств телемедицины</x-sd::doctor.offer.value>
        </div>
    </div>
    @if ($offer->appointment)
        @php($price = $offer->active_price)
        @if ($price)
            <div class="space-y-indent-xs">
                <div class="flex items-center justify-between">
                    <div class="text-h3-mobile sm:text-h3 font-semibold">{{ $price->human_price }}₽</div>
                    <button type="button" class="btn btn-sm btn-primary h-10"
                            wire:loading.attr="disabled"
                            wire:click="showOfferModal({{ $offer->id }})">
                        Записаться на прием
                    </button>
                </div>
                @if ($price->discount)
                    <div class="text-sm text-body/60">
                        Скидка <span class="font-bold">{{ $price->human_discount }}₽</span>{{ $price->discount_condition ? ", " . $price->discount_condition : "" }}
                    </div>
                @endif
                @if ($price->free_condition)
                    <div class="text-sm text-body/60">
                        Бесплатный прием, {{ $price->free_condition }}
                    </div>
                @endif
            </div>
        @else
            <button type="button" class="btn btn-sm btn-primary h-10 w-full"
                    wire:loading.attr="disabled"
                    wire:click="showOfferModal({{ $offer->id }})">
                Записаться на прием
            </button>
        @endif
    @endif
</div>
