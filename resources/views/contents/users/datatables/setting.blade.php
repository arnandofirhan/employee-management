@if ($query->userSetting)
    @if ($query->userSetting->deleted_at)
    @else
        <span class="text-muted fst-italic">
            {{ __('None') }}
        </span>
    @endif
@else
    <span class="text-muted fst-italic">
        {{ __('None') }}
    </span>
@endif
