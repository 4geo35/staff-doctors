@props(['title', 'value' => ''])
@if (! empty($value))
    <div class="flex flex-nowrap items-start justify-between pb-indent-xs last-of-type:pb-0 border-b border-stroke last-of-type:border-none">
        <div class="text-body/60 pr-indent">{{ $title }}</div>
        <div class="text-right">{{ $value }}</div>
    </div>
@endif
