<x-tt::modal.dialog wire:model="displayForm" max-width="lg">
    <x-slot name="content">
        <div class="relative mb-indent">
            <button type="button" wire:click="closeForm"
                    class="cursor-pointer text-body/60 hover:text-body transition-all absolute -top-2.5 -right-2.5">
                <x-tt::ico.cross />
            </button>
            <div class="text-center">
                <x-tt::h3 class="mb-1">{{ config("staff-pages.modalTitle") }}</x-tt::h3>
                @if (! empty(config("staff-pages.modalSubTitle")))
                    <div class="text-body/60 text-lg leading-tight w-10/12 mx-auto">
                        {{ config("staff-pages.modalSubTitle") }}
                    </div>
                @endif
            </div>
        </div>

        @include("sd::web.employees.includes.appointment-form")
    </x-slot>
</x-tt::modal.dialog>
