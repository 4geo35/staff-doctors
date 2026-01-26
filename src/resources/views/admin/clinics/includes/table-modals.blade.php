<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить клинику</x-slot>
    <x-slot name="text">Будет невозможно восстановить клинику!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.dialog wire:model="displayData">
    <x-slot name="title">{{ $clinicId ? "Редактировать" : "Добавить" }} клинику</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $clinicId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="clinicDataForm">

            <div>
                <label for="clinicName" class="inline-block mb-2">
                    Название клиники
                </label>
                <input type="text" id="clinicName"
                       class="form-control {{ $errors->has("name") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="name">
                <div class="text-sm text-info">
                    Указывайте, как в карточке клиники в <a href="https://yandex.ru/support/business-priority/ru/index.html" target="_blank" class="text-primary hover:text-primary-hover">Яндекс Бизнесе</a>.
                </div>
                <x-tt::form.error name="name"/>
            </div>

            <div>
                <label for="clinicAddress" class="inline-block mb-2">
                    Адрес клиники
                </label>
                <input type="text" id="clinicAddress"
                       class="form-control {{ $errors->has("address") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="address">
                <div class="text-sm text-info">
                    Адрес, по которому находится клиника. Указывайте, как в карточке клиники в <a href="https://yandex.ru/support/business-priority/ru/index.html" target="_blank" class="text-primary hover:text-primary-hover">Яндекс Бизнесе</a>.
                </div>
                <x-tt::form.error name="address"/>
            </div>

            <div>
                <label for="clinicCity" class="inline-block mb-2">
                    Город
                </label>
                <input type="text" id="clinicCity"
                       class="form-control {{ $errors->has("city") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="city">
                <x-tt::form.error name="city"/>
            </div>

            <div>
                <label for="clinicEmail" class="inline-block mb-2">
                    Email
                </label>
                <input type="text" id="clinicEmail"
                       class="form-control {{ $errors->has("email") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="email">
                <x-tt::form.error name="email"/>
            </div>

            <div>
                <label for="clinicPhone" class="inline-block mb-2">
                    Номер телефона
                </label>
                <input type="text" id="clinicPhone"
                       class="form-control {{ $errors->has("phone") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="phone">
                <x-tt::form.error name="phone"/>
            </div>

            <div>
                <label for="clinicCompanyId" class="inline-block mb-2">
                    Идентификатор организации в поиске
                </label>
                <input type="text" id="clinicCompanyId"
                       class="form-control {{ $errors->has("clinicId") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="clinicId">
                <div class="text-sm text-info">
                    Например, 1032739194.
                    <br>
                    В случае ошибки автоматического определения идентификатора можно использовать идентификатор из Яндекс Карт
                    <ol class="list-decimal ml-indent mt-2 space-y-1">
                        <li>Перейдите в карточку нужной организации в <a href="https://yandex.ru/support/business-priority/ru/index.html" target="_blank" class="text-primary hover:text-primary-hover">Яндекс Бизнесе</a>.</li>
                        <li>Чтобы открыть профиль организации, нажмите Профиль. Цифры из ссылки будут идентификатором организации. Например, для ссылки https://yandex.ru/profile/1032739194 идентификатор организации 1032739194.</li>
                    </ol>
                </div>
                <x-tt::form.error name="clinicId"/>
            </div>

            @if (config("contact-page"))
                <div>
                    <div class="inline-block mb-2">Контакт</div>
                    @isset($contacts)
                        <select class="form-select {{ $errors->has('contactId') ? 'border-danger' : '' }}"
                                wire:model="contactId">
                            <option value="">Выберите...</option>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->title }}</option>
                            @endforeach
                        </select>
                        <div class="text-sm text-info">
                            При подключении к контакту данные синхронизируются.
                        </div>
                        <x-tt::form.error name="contactId"/>
                    @endisset
                </div>
            @endif

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="clinicDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $clinicId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.dialog>
