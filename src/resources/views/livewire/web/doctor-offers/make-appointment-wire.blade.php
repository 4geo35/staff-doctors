<div id="make-appointment" class="mt-indent-lg {{ !$services->count() ? 'hidden' : '' }}">
    @if ($services->count())
        <x-tt::h2 class="mb-indent">Записаться на прием</x-tt::h2>

        @if ($services->count() > 1)
            <div class="px-indent-xs pt-indent-xs rounded-base bg-white mb-indent">
                <x-tt::h5 class="mb-indent-sm">Выберите услугу для записи</x-tt::h5>
                <div class="flex flex-wrap">
                    @foreach($services as $service)
                        <button type="button" wire:click="switchService('{{ $service->slug }}')" wire:loading.attr="disabled"
                                class="btn {{ $activeService === $service->slug ? 'btn-secondary' : 'btn-outline-secondary' }} btn-sm mb-indent-xs mr-indent-xs">
                            {{ $service->title }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($offers)
            <div class="row">
                @foreach($offers as $offer)
                    <div class="col w-full md:w-1/2 mb-indent">
                        <x-sd::doctor.offer.teaser :$offer />
                    </div>
                @endforeach
            </div>
        @else
            <div>Нет доступных приемов</div>
        @endif
    @endif
</div>
