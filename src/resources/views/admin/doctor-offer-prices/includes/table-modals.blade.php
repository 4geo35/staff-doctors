<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить цену</x-slot>
    <x-slot name="text">Будет невозможно восстановить цену!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $priceId ? "Редактировать" : "Добавить" }} цену</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $priceId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="doctorOfferPriceDataForm">

            <div>
                <label for="doctorOfferPricePrice" class="inline-block mb-2">
                    Цена<span class="text-danger">*</span>
                </label>
                <input type="number" step="0.01" id="doctorOfferPricePrice"
                       class="form-control {{ $errors->has("price") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="price">
                <x-tt::form.error name="price"/>
            </div>

            <div>
                <label for="doctorOfferPriceDiscount" class="inline-block mb-2">
                    Скидка
                </label>
                <input type="number" step="0.01" id="doctorOfferPriceDiscount"
                       class="form-control {{ $errors->has("discount") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="discount">
                <x-tt::form.error name="discount"/>
            </div>

            <div>
                <label for="doctorOfferPriceDiscountCondition" class="inline-block mb-2">
                    Условия получения скидки
                </label>
                <input type="text" id="doctorOfferPriceDiscountCondition"
                       class="form-control {{ $errors->has("discountCondition") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="discountCondition">
                <x-tt::form.error name="discountCondition"/>
            </div>

            <div>
                <label for="doctorOfferPriceFreeCondition" class="inline-block mb-2">
                    Условия бесплатного приема
                </label>
                <input type="text" id="doctorOfferPriceFreeCondition"
                       class="form-control {{ $errors->has("freeCondition") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="freeCondition">
                <x-tt::form.error name="freeCondition"/>
            </div>
            
            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="doctorOfferPriceDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $priceId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
