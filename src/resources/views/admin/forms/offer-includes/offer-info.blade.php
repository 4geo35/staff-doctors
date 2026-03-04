@php($offer = $item->recordable->offer)
@if ($offer)
    <div class="space-y-1">
        @if ($offer->offer_id)
            <div class="flex flex-nowrap justify-start space-x-indent-half">
                <div class="font-semibold">Предложение:</div>
                <div>
                    <a href="{{ route("admin.doctor-offers.show", ["offer" => $offer->offer]) }}"
                       target="_blank"
                       class="text-primary hover:text-primary-hover">
                        Просмотр
                    </a>
                </div>
            </div>
        @endif

        <div class="flex flex-nowrap justify-start space-x-indent-half">
            <div class="font-semibold">Специалист:</div>
            <div class="text-nowrap">{{ $item->recordable->fio }}</div>
        </div>

        <div class="flex flex-nowrap justify-start space-x-indent-half">
            <div class="font-semibold">Клиника:</div>
            <div class="text-nowrap">{{ $offer->clinic_title }}</div>
        </div>

        <div class="flex flex-nowrap justify-start space-x-indent-half">
            <div class="font-semibold">Услуга:</div>
            <div class="text-nowrap">{{ $offer->service_title }}</div>
        </div>

        <div class="flex flex-nowrap justify-start space-x-indent-half">
            <div class="font-semibold">Специальность:</div>
            <div class="text-nowrap">{{ $offer->department_title }}</div>
        </div>

        <div class="flex flex-nowrap justify-start space-x-indent-half">
            <div class="font-semibold">Цена:</div>
            <div class="text-nowrap">{{ $offer->human_price }}</div>
        </div>
    </div>
@else
    Заявка без предложения
@endif
