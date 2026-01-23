<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить образование</x-slot>
    <x-slot name="text">Будет невозможно восстановить образование!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $educationId ? 'Редактировать' : 'Добавить' }} образование</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $educationId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="doctorEducationDataForm">

            <div>
                <label for="doctorEducationOrganization" class="inline-block mb-2">
                    Образовательное учреждение
                </label>
                <input type="text" id="doctorEducationOrganization"
                       class="form-control {{ $errors->has("organization") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="organization">
                <div class="text-sm text-info">Например, Астраханская государственная медицинская академия.</div>
                <x-tt::form.error name="organization"/>
            </div>

            <div>
                <label for="doctorEducationFinishYear" class="inline-block mb-2">
                    Год окончания обучения
                </label>
                <input type="number" id="doctorEducationFinishYear"
                       class="form-control {{ $errors->has("finishYear") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="finishYear">
                <x-tt::form.error name="finishYear"/>
            </div>

            <div>
                <label for="doctorEducationType" class="inline-block mb-2">
                    Уровень образования
                </label>
                <input type="text" id="doctorEducationType"
                       class="form-control {{ $errors->has("type") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="type">
                <div class="text-sm text-info">Например: базовое, ординатура, специалитет и т.п.</div>
                <x-tt::form.error name="type"/>
            </div>

            <div>
                <label for="doctorEducationSpecialization" class="inline-block mb-2">
                    Специализация
                </label>
                <input type="text" id="doctorEducationSpecialization"
                       class="form-control {{ $errors->has("specialization") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="specialization">
                <x-tt::form.error name="specialization"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="doctorEducationDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $educationId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
