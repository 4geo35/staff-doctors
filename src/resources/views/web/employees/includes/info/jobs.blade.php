@if($info->orderedJobs->count())
    <div class="mt-indent-lg">
        <x-tt::h2 class="mb-indent">Места работы</x-tt::h2>
        <div class="space-y-indent-sm">
            @foreach($info->orderedJobs as $job)
                <x-sd::doctor.block>
                    <x-sd::doctor.block.item title="Организация" :value="$job->organization" />
                    <x-sd::doctor.block.item title="Период работы" :value="$job->period_years" />
                    <x-sd::doctor.block.item title="Должность и специализация" :value="$job->position" />
                </x-sd::doctor.block>
            @endforeach
        </div>
    </div>
@endif
