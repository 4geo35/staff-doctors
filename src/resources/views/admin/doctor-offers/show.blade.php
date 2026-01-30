<x-admin-layout>
    <x-slot name="title">Просмотр предложения</x-slot>
    <x-slot name="pageTitle">Просмотр предложения</x-slot>

    <div class="space-y-indent-half">
        <livewire:sd-admin-doctor-offers-show :$offer />
        <livewire:sd-admin-doctor-offer-price-list :$offer />
    </div>
</x-admin-layout>
