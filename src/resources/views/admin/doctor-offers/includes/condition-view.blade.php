@props(["item"])
<ul class="space-y-2 min-w-[250px]">
    <li><x-sd::bool-value :value="$item->oms">Возможность попасть на прием по полису ОМС</x-sd::bool-value></li>
    <li><x-sd::bool-value :value="$item->appointment">Ведет ли врач прием</x-sd::bool-value></li>
    <li><x-sd::bool-value :value="$item->children">Прием детей (до 18 лет)</x-sd::bool-value></li>
    <li><x-sd::bool-value :value="$item->adult">Прием взрослых</x-sd::bool-value></li>
    <li><x-sd::bool-value :value="$item->house_call">Вызов врача на дом</x-sd::bool-value></li>
    <li><x-sd::bool-value :value="$item->telemedicine">Оказание услуги с использованием средств телемедицины</x-sd::bool-value></li>
</ul>
