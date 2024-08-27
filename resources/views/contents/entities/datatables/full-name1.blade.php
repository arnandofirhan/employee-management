<div class="d-flex justify-content-start flex-column">
    <!-- <span class="fw-semibold d-block fs-7">
        {{ $query->full_name }}
    </span> -->
    <span class="d-block fw-semibold d-block fs-7">
        @if ($query->identity_number)
            {{ $query->identity_number }}
        @else
            <span class="text-muted fst-italic text-nowrap">{{ __('None') }}</span>
        @endif
    </span>
</div>
