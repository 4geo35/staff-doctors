<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить предложение</x-slot>
    <x-slot name="text">Будет невозможно восстановить предложение!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.dialog wire:model="displayData">
    <x-slot name="title">{{ $offerId ? "Редактировать" : "Добавить" }} предложение</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $offerId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="doctorOfferDataForm">

            <div>
                <div class="inline-block mb-2">Услуга<span class="text-danger">*</span></div>
                @isset($serviceList)
                    <select class="form-select {{ $errors->has('serviceId') ? 'border-danger' : '' }}"
                            required
                            wire:model="serviceId">
                        <option value="">Выберите...</option>
                        @foreach($serviceList as $serviceItem)
                            <option value="{{ $serviceItem->id }}">{{ $serviceItem->title }}</option>
                        @endforeach
                    </select>
                    <x-tt::form.error name="serviceId"/>
                @endisset
            </div>

            <div>
                <div class="inline-block mb-2">Клиника<span class="text-danger">*</span></div>
                @isset($clinicList)
                    <select class="form-select {{ $errors->has('clinicId') ? 'border-danger' : '' }}"
                            required
                            wire:model="clinicId">
                        <option value="">Выберите...</option>
                        @foreach($clinicList as $clinicItem)
                            <option value="{{ $clinicItem->id }}">{{ $clinicItem->name }}</option>
                        @endforeach
                    </select>
                    <x-tt::form.error name="clinicId"/>
                @endisset
            </div>

            <div>
                <div class="inline-block mb-2">Доктор<span class="text-danger">*</span></div>
                @isset($doctorList)
                    <select class="form-select {{ $errors->has('doctorId') ? 'border-danger' : '' }}"
                            required
                            wire:model="doctorId">
                        <option value="">Выберите...</option>
                        @foreach($doctorList as $doctorItem)
                            <option value="{{ $doctorItem->id }}">{{ $doctorItem->fio }}</option>
                        @endforeach
                    </select>
                    <x-tt::form.error name="doctorId"/>
                @endisset
            </div>

            <div>
                <div class="inline-block mb-2">Специальность (Отдел)<span class="text-danger">*</span></div>
                @isset($departmentList)
                    <select class="form-select {{ $errors->has('departmentId') ? 'border-danger' : '' }}"
                            required
                            wire:model="departmentId">
                        <option value="">Выберите...</option>
                        @foreach($departmentList as $departmentItem)
                            <option value="{{ $departmentItem->id }}">{{ $departmentItem->title }}</option>
                        @endforeach
                    </select>
                    <x-tt::form.error name="departmentId"/>
                @endisset
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="oms" id="doctorOfferOms"
                       class="form-check-input {{ $errors->has('oms') ? 'border-danger' : '' }}"/>
                <label for="doctorOfferOms" class="form-check-label">
                    Возможность попасть на прием по полису ОМС
                </label>
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="appointment" id="doctorOfferAppointment"
                       class="form-check-input {{ $errors->has('appointment') ? 'border-danger' : '' }}"/>
                <label for="doctorOfferAppointment" class="form-check-label">
                    Ведет ли врач прием
                </label>
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="children" id="doctorOfferChildren"
                       class="form-check-input {{ $errors->has('children') ? 'border-danger' : '' }}"/>
                <label for="doctorOfferChildren" class="form-check-label">
                    Прием детей (до 18 лет)
                </label>
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="adult" id="doctorOfferAdult"
                       class="form-check-input {{ $errors->has('adult') ? 'border-danger' : '' }}"/>
                <label for="doctorOfferAdult" class="form-check-label">
                    Прием взрослых
                </label>
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="houseCall" id="doctorOfferHouseCall"
                       class="form-check-input {{ $errors->has('houseCall') ? 'border-danger' : '' }}"/>
                <label for="doctorOfferHouseCall" class="form-check-label">
                    Вызов врача на дом
                </label>
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="telemedicine" id="doctorOfferTelemedicine"
                       class="form-check-input {{ $errors->has('telemedicine') ? 'border-danger' : '' }}"/>
                <label for="doctorOfferTelemedicine" class="form-check-label">
                    Оказание услуги с использованием средств телемедицины
                </label>
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="isBaseService" id="doctorOfferIsBaseService"
                       class="form-check-input {{ $errors->has('isBaseService') ? 'border-danger' : '' }}"/>
                <label for="doctorOfferIsBaseService" class="form-check-label">
                    Признак базовой услуги
                </label>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="doctorOfferDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $offerId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
