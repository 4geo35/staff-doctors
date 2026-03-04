<div class="space-y-indent-half">
    <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
        <input type="text" aria-label="Имя" placeholder="Имя" class="form-control" wire:model.live="searchName">
        <input type="text" aria-label="Телефон" placeholder="Телефон" class="form-control" wire:model.live="searchPhone">
        <input type="text" aria-label="{{ config("staff-pages.modalEmployeeFieldTitle") }}" placeholder="{{ config("staff-pages.modalEmployeeFieldTitle") }}" class="form-control" wire:model.live="searchFio">
        @include("rf::admin.forms.includes.date-search")
        <button type="button" class="btn btn-outline-primary" wire:click="clearSearch">
            Очистить
        </button>
    </div>

    @include("rf::admin.forms.includes.info-search")

    <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
        <input type="text" aria-label="Клиника" placeholder="Клиника" class="form-control" wire:model.live="searchClinic">
        <input type="text" aria-label="Услуга" placeholder="Услуга" class="form-control" wire:model.live="searchService">
        <input type="text" aria-label="Специальность" placeholder="Специальность" class="form-control" wire:model.live="searchDepartment">
    </div>
</div>
