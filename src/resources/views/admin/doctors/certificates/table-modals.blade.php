<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить сертификат</x-slot>
    <x-slot name="text">Будет невозможно восстановить сертификат!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $certificateId ? "Редактировать" : "Добавить" }} сертификат</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $certificateId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="doctorCertificateDataForm">

            <div>
                <label for="doctorCertificateOrganization" class="inline-block mb-2">
                    Организация
                </label>
                <input type="text" id="doctorCertificateOrganization"
                       class="form-control {{ $errors->has("organization") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="organization">
                <x-tt::form.error name="organization"/>
            </div>

            <div>
                <label for="doctorCertificateFinishYear" class="inline-block mb-2">
                    Год выдачи сертификата
                </label>
                <input type="number" id="doctorCertificateFinishYear"
                       class="form-control {{ $errors->has("finishYear") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="finishYear">
                <x-tt::form.error name="finishYear"/>
            </div>

            <div>
                <label for="doctorCertificateName" class="inline-block mb-2">
                    Название сертификата
                </label>
                <input type="text" id="doctorCertificateName"
                       class="form-control {{ $errors->has("name") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="name">
                <x-tt::form.error name="name"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="doctorCertificateDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $certificateId ? 'Обновить' : 'Добавить' }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
