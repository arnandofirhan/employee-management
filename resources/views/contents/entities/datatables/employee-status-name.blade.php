<div class="d-flex justify-content-start flex-column">
    <span class="fw-semibold d-block fs-6">
        @if ($query->employeeStatus)
            {{ $query->employeeStatus->name }}
        @else
            <span class="text-muted fst-italic text-nowrap">{{ __('None') }}</span>
        @endif
    </span>
    <!-- <span class="d-block text-gray-800 fw-semibold d-block fs-8">
        <x-date-format :date="$query->join_date" format='l, j F Y' />
    </span> -->
</div>
