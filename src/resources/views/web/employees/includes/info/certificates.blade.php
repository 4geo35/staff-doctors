@if($info->orderedCertificates->count())
    <div class="mt-indent-lg">
        <x-tt::h2 class="mb-indent">Сертификаты</x-tt::h2>
        <div class="space-y-indent-sm">
            @foreach($info->orderedCertificates as $certificate)
                <x-sd::doctor.block>
                    <x-sd::doctor.block.item title="Организация" :value="$certificate->organization" />
                    <x-sd::doctor.block.item title="Год выдачи" :value="$certificate->finish_year" />
                    <x-sd::doctor.block.item title="Название сертификата" :value="$certificate->name" />
                </x-sd::doctor.block>
            @endforeach
        </div>
    </div>
@endif
