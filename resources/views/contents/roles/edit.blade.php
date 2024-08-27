<?php
$title = __('Edit :name', ['name' => $query->name]);
$breadcrumbs = [
    [
        'name' => __('Roles'),
        'url' => route('roles.index'),
    ],
    [
        'name' => __('Edit :name', ['name' => $query->name]),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container">
        <div class="card mb-8 mb-xl-10">
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ __('Edit :name', ['name' => $query->name]) }}</h3>
                </div>
            </div>

            <form id="form" onsubmit="return false" novalidate="novalidate" class="form"
                data-url-action="{{ route('roles.update', $query->id) }}">
                @method('PUT')

                <div class="card-body border-top p-9">
                    <div class="row">
                        <div class="col-sm-12 mb-10 fv-row">
                            <label for="name" class="fs-6 fw-semibold form-label required">
                                {{ __('Name') }}
                            </label>
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid"
                                value="{{ $query->name }}" placeholder="{{ __('Name') }}"
                                autocomplete="one-time-code" />
                        </div>
                    </div>

                    <div class="row">
                        @forelse ($permissions as $roleName => $permissions)
                            <div class="mb-10 col-md-3 col-sm-6 ps-7 pe-7" card-item>
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid align-items-start cursor-pointer">
                                    <input type="checkbox" class="form-check-input me-2" value="true"
                                        checkbox-select-all
                                        {{ isset($rolePermissionIds[$roleName]) && $permissions->count() == count($rolePermissionIds[$roleName]) ? 'checked' : '' }} />
                                    <span class="form-check-label d-flex flex-column align-items-start">
                                        <span class="fw-bold fs-5 mb-0">{{ $roleName }}</span>
                                    </span>
                                </label>
                                <div class="separator separator-solid my-3 border-primary"></div>

                                <div list-group>
                                    @foreach ($permissions as $item)
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid align-items-start cursor-pointer">
                                            <input type="checkbox" name="permissions[]" class="form-check-input me-2"
                                                value="{{ $item->id }}" checkbox-select-item
                                                {{ isset($rolePermissionIds[$roleName]) && in_array($item->id, $rolePermissionIds[$roleName]) ? 'checked' : '' }} />

                                            <span class="form-check-label d-flex flex-column align-items-start">
                                                <span class="fs-5 mb-0">{{ $item->name }}</span>
                                            </span>
                                        </label>

                                        @if ($loop->last === false)
                                            <div class="separator separator-dashed my-3 "></div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('roles.index') }}" class="btn btn-light btn-active-light-secondary me-2">
                        {{ __('Back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">{{ __('Save Changes') }}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('vendor/form-render/edit.js') }}"></script>
        <script src="{{ asset('vendor/form-render/checkbox.js') }}"></script>

        <script>
            handleInitEdit(`#form`, {
                name: {
                    validators: {
                        notEmpty: {
                            message: "Name is required",
                        },
                    },
                },
            });
        </script>
    </x-slot>
</x-main-app-layout>
