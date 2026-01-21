<div class="row">
    <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
        <div class="row">
            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                <h3 class="font-semibold">Научная степень врача</h3>
            </div>
            <div class="col w-full xs:w-3/5">{{ $doctorInfo->degree }}</div>
        </div>

        <div class="row">
            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                <h3 class="font-semibold">Научное звание врача</h3>
            </div>
            <div class="col w-full xs:w-3/5">{{ $doctorInfo->rank }}</div>
        </div>

        <div class="row">
            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                <h3 class="font-semibold">Категория врача</h3>
            </div>
            <div class="col w-full xs:w-3/5">{{ $doctorInfo->category }}</div>
        </div>
    </div>

    <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
        <div class="row">
            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                <h3 class="font-semibold">Стаж врача</h3>
            </div>
            <div class="col w-full xs:w-3/5">{{ $doctorInfo->experience_years }}</div>
        </div>

        <div class="row">
            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                <h3 class="font-semibold">Дата начала карьеры врача</h3>
            </div>
            <div class="col w-full xs:w-3/5">{{ $doctorInfo->career_start_date }}</div>
        </div>
    </div>
</div>
