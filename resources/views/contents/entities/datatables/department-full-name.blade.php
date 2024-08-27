@if ($query->department)
    {{ $query->department->full_name }}
@else
    <span class="text-muted fst-italic text-nowrap">{{ __('None') }}</span>
@endif
