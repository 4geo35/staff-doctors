@php($doctorInfo = $employee->doctorInfo)
@if (! empty($doctorInfo) && $doctorInfo->published_at)
    <a href="{{ route('web.employees.doctor', ['employee' => $employee]) }}"
       class="btn btn-outline-primary w-full">
        {{ config("staff-doctors.teaserShowBtnTitle") }}
    </a>
@endif
