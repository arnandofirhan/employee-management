<div class="d-flex justify-content-start flex-column text-uppercase">
    <!-- <span class="fw-semibold d-block fs-7">
        @switch($query->gender_category)
            @case(App\Constants\GenderCategoryConstant::MALE)
                Laki-Laki
            @break

            @case(App\Constants\GenderCategoryConstant::FEMALE)
                Perempuan
            @break

            @default
                <span class="text-muted fst-italic text-nowrap">{{ __('None') }}</span>
        @endswitch
    </span> -->
    <span class="d-block fw-semibold d-block fs-7">
        {{ $query->birth_place }}, 
        <x-date-format :date="$query->birth_date" format='j F Y' />
    </span>
</div>
