@if ($query->phone)
    {{ $query->phone }}
@else
    <span class="text-muted fst-italic text-nowrap">{{ __('None') }}</span>
@endif
