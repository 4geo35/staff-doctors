<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить работу</x-slot>
    <x-slot name="text">Будет невозможно восстановить работу!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $jobId ? "Редактировать" : "Добавить" }} место работы</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $jobId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="doctorJobDataForm">

            <div>
                <label for="doctorJobOrganization" class="inline-block mb-2">
                    Организация
                </label>
                <input type="text" id="doctorJobOrganization"
                       class="form-control {{ $errors->has("organization") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="organization">
                <x-tt::form.error name="organization"/>
            </div>

            <div>
                <label for="doctorJobPeriodYears" class="inline-block mb-2">
                    Период работы в организации
                </label>
                <input type="text" id="doctorJobPeriodYears"
                       class="form-control {{ $errors->has("periodYears") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="periodYears">
                <div class="text-sm text-info">Например, 2007-2009 или 2009-н.в.</div>
                <x-tt::form.error name="periodYears"/>
            </div>

            <div>
                <label for="doctorJobPosition" class="inline-block mb-2">
                    Должность и специализация
                </label>
                <input type="text" id="doctorJobPosition"
                       class="form-control {{ $errors->has("position") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="position">
                <div class="text-sm text-info">Например, зав. отделением хирургии, врач-педиатр.</div>
                <x-tt::form.error name="position"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="doctorJobDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $jobId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
