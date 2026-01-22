<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">Редактировать информацию</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="update" class="space-y-indent-half" id="doctorInfoDataForm">

            <div>
                <label for="doctorInfoExperienceYears" class="inline-block mb-2">
                    Стаж врача — число полных лет.
                </label>
                <input type="text" id="doctorInfoExperienceYears"
                       class="form-control {{ $errors->has("experienceYears") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="experienceYears">
                <x-tt::form.error name="experienceYears"/>
            </div>

            <div>
                <label for="doctorCareerStartDate" class="inline-block mb-2">
                    Дата начала карьеры врача
                </label>
                <input type="date" id="doctorCareerStartDate"
                       class="form-control {{ $errors->has("careerStartDate") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="careerStartDate">
                <div class="text-sm text-info">Если точной даты нет, укажите 1 января года начала карьеры.</div>
                <x-tt::form.error name="careerStartDate"/>
            </div>

            <div>
                <label for="doctorDegree" class="inline-block mb-2">
                    Научная степень врача
                </label>
                <input type="text" id="doctorDegree"
                       class="form-control {{ $errors->has("degree") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="degree">
                <div class="text-sm text-info">Рекомендуемые значения: кандидат медицинских наук, доктор медицинских наук и др.</div>
                <x-tt::form.error name="degree"/>
            </div>

            <div>
                <label for="doctorRank" class="inline-block mb-2">
                    Научное звание врача
                </label>
                <input type="text" id="doctorRank"
                       class="form-control {{ $errors->has("rank") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="rank">
                <div class="text-sm text-info">Рекомендуемые значения: профессор, доцент и др.</div>
                <x-tt::form.error name="rank"/>
            </div>

            <div>
                <label for="doctorCategory" class="inline-block mb-2">
                    Категория врача
                </label>
                <input type="text" id="doctorCategory"
                       class="form-control {{ $errors->has("category") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="category">
                <div class="text-sm text-info">Рекомендуемые значения: высшая, первая, вторая.</div>
                <x-tt::form.error name="category"/>
            </div>

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
