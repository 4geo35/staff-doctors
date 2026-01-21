<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h3 class="font-medium text-2xl text-nowrap mr-indent-half">
        Расширенная информация
    </h3>

    <div class="flex justify-end">
        <button type="button" class="btn btn-dark px-btn-x-ico"
                @cannot("update", $employee) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showEdit()">
            <x-tt::ico.edit />
        </button>
    </div>
</div>
