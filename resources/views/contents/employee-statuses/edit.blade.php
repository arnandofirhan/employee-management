<?php
$title = __('Edit :name', ['name' => $query->name]);
$breadcrumbs = [
    [
        'name' => __('Employee Statuses'),
        'url' => route('employee-statuses.index'),
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
                data-url-action="{{ route('employee-statuses.update', $query->id) }}">
                @method('PUT')

                <div class="card-body border-top p-9">
                    <div class="row">
                        <div class="col-sm-12 mb-10 fv-row">
                            <label class="fs-6 fw-semibold form-label">
                                {{ __('Status') }}
                            </label>
                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                <input type="checkbox" id="is_active" name="status" class="form-check-input w-50px"
                                    value="1" {{ $query->is_active ? 'checked' : '' }} />
                                <label class="form-check-label cursor-pointer" for="is_active">
                                    {{ __('Is Active :name', ['name' => strtolower(__('Regency'))]) }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-0 fv-row">
                            <label for="name" class="fs-6 fw-semibold form-label required">
                                {{ __('Name') }}
                            </label>
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid"
                                value="{{ $query->name }}" placeholder="{{ __('Name') }}"
                                autocomplete="one-time-code" />
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('employee-statuses.index') }}"
                        class="btn btn-light btn-active-light-secondary me-2">
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

        <script>
            handleInitEdit(`#form`, {
                name: {
                    validators: {
                        notEmpty: {
                            message: "The name is required",
                        },
                    },
                },
            });
        </script>
    </x-slot>
</x-main-app-layout>
