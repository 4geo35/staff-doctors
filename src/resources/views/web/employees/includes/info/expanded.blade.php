@if (
        ! empty($info->human_experience_years) ||
        ! empty($info->degree) ||
        ! empty($info->human_start_date) ||
        ! empty($info->rank) ||
        ! empty($info->category)
    )
    <x-sd::doctor.block>
        <x-sd::doctor.block.item title="Стаж работы" :value="$info->human_experience_years" />
        <x-sd::doctor.block.item title="Научная степень" :value="$info->degree" />
        <x-sd::doctor.block.item title="Начало карьеры" :value="$info->human_start_date" />
        <x-sd::doctor.block.item title="Научное звание" :value="$info->rank" />
        <x-sd::doctor.block.item title="Категория врача" :value="$info->category" />
    </x-sd::doctor.block>
@endif
