<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить услугу</x-slot>
    <x-slot name="text">Будет невозможно восстановить услугу!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $serviceId ? "Редактировать" : "Добавить" }} услугу</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $serviceId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="doctorServiceDataForm">

            <div>
                <label for="doctorServiceTitle" class="inline-block mb-2">
                    Наименование<span class="text-danger">*</span>
                </label>
                <input type="text" id="doctorServiceTitle"
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div>
                <label for="doctorServiceSlug" class="inline-block mb-2">
                    Уникальный идентификатор
                </label>
                <input type="text" id="doctorServiceSlug"
                       class="form-control {{ $errors->has("slug") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="slug">
                <x-tt::form.error name="slug"/>
            </div>

            <div>
                <label for="doctorServiceGovId" class="inline-block mb-2">
                    Код медицинской услуги
                </label>
                <input type="text" id="doctorServiceGovId"
                       class="form-control {{ $errors->has("govId") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="govId">
                <div class="text-sm text-info">
                    Код медицинской услуги по <a href="https://docs.cntd.ru/document/542609980" target="_blank" class="text-primary hover:text-primary-hover">перечню</a> Министерства здравоохранения РФ.
                </div>
                <x-tt::form.error name="govId"/>
            </div>

            <div>
                <label for="doctorServiceShort" class="inline-block mb-2">
                    Описание
                </label>
                <input type="text" id="doctorServiceShort"
                       class="form-control {{ $errors->has("short") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="short">
                <x-tt::form.error name="short"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="doctorServiceDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $serviceId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
