<?php
$title = __('Edit :name', ['name' => $query->name]);
$breadcrumbs = [
    [
        'name' => __('Entity Categories'),
        'url' => route('entity-categories.index'),
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
                data-url-action="{{ route('entity-categories.update', $query->id) }}">
                @method('PUT')

                <div class="card-body border-top p-9">
                    <div class="row">
                        <div class="col-sm-6 mb-10 fv-row">
                            <label for="background_color_code" class="fs-6 fw-semibold form-label required">
                                {{ __('Background Color Code') }}
                            </label>
                            <input type="text" name="background_color_code"
                                class="form-control form-control-lg form-control-solid"
                                value="{{ $query->background_color_code }}"
                                placeholder="{{ __('Background Color Code') }}" autocomplete="one-time-code" />
                        </div>
                        <div class="col-sm-6 mb-10 fv-row">
                            <label for="font_color_code" class="fs-6 fw-semibold form-label required">
                                {{ __('Font Color Code') }}
                            </label>
                            <input type="text" name="font_color_code"
                                class="form-control form-control-lg form-control-solid"
                                value="{{ $query->font_color_code }}" placeholder="{{ __('Font Color Code') }}"
                                autocomplete="one-time-code" />
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('entity-categories.index') }}"
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
                background_color_code: {
                    validators: {
                        notEmpty: {
                            message: "Background color code is required",
                        },
                    },
                },
                font_color_code: {
                    validators: {
                        notEmpty: {
                            message: "Font color code is required",
                        },
                    },
                },
            });
        </script>
    </x-slot>
</x-main-app-layout>
