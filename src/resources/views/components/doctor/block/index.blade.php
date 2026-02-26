<div class="p-indent bg-white rounded-base">
    @isset($title)
        <x-tt::h4 class="mb-indent-sm">{{ $title }}</x-tt::h4>
    @endisset
    <div class="space-y-indent-sm">
        {{ $slot }}
    </div>
</div>
