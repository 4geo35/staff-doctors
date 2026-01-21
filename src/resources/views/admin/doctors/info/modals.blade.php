<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">Редактировать информацию</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="update" class="space-y-indent-half" id="doctorInfoDataForm">



            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="doctorInfoDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    Обновить
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
