@if ($query->job_placement)
    {{ $query->job_placement}}
@else
    <span class="text-muted fst-italic text-nowrap">{{ __('None') }}</span>
@endif
