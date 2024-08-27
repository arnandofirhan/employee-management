@if ($query->email)
    {{ $query->email }}
@else
    <span class="text-muted fst-italic">{{ __('None') }}</span>
@endif
