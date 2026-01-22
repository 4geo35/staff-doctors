<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h3 class="font-medium text-2xl text-nowrap mr-indent-half">
        Образование
    </h3>

    <div class="flex justify-end">
        <button type="button" class="btn btn-primary px-btn-x-ico"
                @cannot("update", $employee) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showCreate">
            <x-tt::ico.circle-plus />
            <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
        </button>
    </div>
</div>
