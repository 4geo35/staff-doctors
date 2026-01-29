@props(["value"])
<span>{{ $slot }}: <span class="{{ $value ? 'text-success' : 'text-danger' }} font-semibold">{{ $value ? "Да" : "Нет" }}</span></span>
