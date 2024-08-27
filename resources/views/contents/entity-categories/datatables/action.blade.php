@if (
    $query->is_active == true &&
        auth()->user()->hasAnyPermission(['entity-category.edit']))
    <a href="#" class="btn btn-flex btn-sm btn-light btn-center btn-active-light-primary ps-5 pe-3"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        {{ __('More') }}
        <i class="ki-solid ki-down fs-5 ms-1"></i>
    </a>

    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-3"
        data-kt-menu="true">
        @can('entity-category.edit')
            <div class="menu-item px-3">
                <a href="{{ route('entity-categories.edit', $query->id) }}" class="menu-link px-3">
                    <i class="ki-solid ki-pencil fs-4 me-2 text-warning"></i>
                    {{ __('Edit') }}
                </a>
            </div>
        @endcan
    </div>
@else
    <span class="text-muted fst-italic text-nowrap">{{ __('Not Allowed') }}</span>
@endif
