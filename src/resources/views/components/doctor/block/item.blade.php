@props(['title', 'value' => ''])
@if (! empty($value))
    <div class="flex flex-wrap md:flex-nowrap items-start md:justify-between pb-indent-xs last-of-type:pb-0 border-b border-stroke last-of-type:border-none">
        <div class="w-full md:w-auto mb-indent-xs md:mb-0 text-body/60 text-nowrap pr-indent">{{ $title }}</div>
        <div class="w-full md:w-auto md:text-right">{{ $value }}</div>
    </div>
@endif
