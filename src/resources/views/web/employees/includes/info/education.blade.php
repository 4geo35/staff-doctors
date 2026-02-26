@if($info->orderedEducation->count())
    <div class="mt-indent-lg">
        <x-tt::h2 class="mb-indent">Образование</x-tt::h2>
        <div class="space-y-indent-sm">
            @foreach($info->orderedEducation as $education)
                <x-sd::doctor.block>
                    <x-sd::doctor.block.item title="Организация" :value="$education->organization" />
                    <x-sd::doctor.block.item title="Год окончания" :value="$education->finish_year" />
                    <x-sd::doctor.block.item title="Уровень образования" :value="$education->type" />
                    <x-sd::doctor.block.item title="Специализация" :value="$education->specialization" />
                </x-sd::doctor.block>
            @endforeach
        </div>
    </div>
@endif
