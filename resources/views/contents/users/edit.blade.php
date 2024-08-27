<?php
$title = __('Edit :name', ['name' => $query->full_name]);
$breadcrumbs = [
    [
        'name' => __('Users'),
        'url' => route('users.index'),
    ],
    [
        'name' => __('Edit :name', ['name' => $query->full_name]),
        'url' => route('users.edit', $query->id),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container">
        <div class="d-flex flex-column flex-lg-row">
            @include('contents.users.partials.sidebar')
            <div class="flex-lg-row-fluid ms-lg-15">
                @include('contents.users.partials.navbar')
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <div class="card mb-8 mb-xl-10">
                            <div class="card-header border-0">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">{{ __('Profile Details') }}</h3>
                                </div>
                            </div>

                            <form id="form_profile_details" onsubmit="return false" novalidate="novalidate"
                                class="form" data-url-action="{{ route('users.update', $query->id) }}">
                                @method('PUT')

                                <div class="card-body border-top p-9">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            {{ __('Status') }}
                                        </label>
                                        <div class="col-lg-8">
                                            <div
                                                class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                                <input type="checkbox" id="is_active" name="status"
                                                    class="form-check-input w-50px" value="1"
                                                    {{ $query->is_active ? 'checked' : '' }} />
                                                <label class="form-check-label cursor-pointer" for="is_active">
                                                    {{ __('Is Active :name', ['name' => strtolower(__('Account'))]) }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            {{ __('Avatar') }}
                                        </label>
                                        <div class="col-lg-8">
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                style="background-image: url('{{ asset('themes/main/media/svg/avatars/blank.svg') }}')">
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url({{ $query->full_image_url }})">
                                                </div>
                                                <label for="image"
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    title="{{ __('Change Avatar') }}">
                                                    <i class="ki-duotone ki-pencil fs-7">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <input type="file" id="image" name="image"
                                                        accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="is_image_removed" />
                                                </label>
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    title="{{ __('Cancel Avatar') }}">
                                                    <i class="ki-duotone ki-cross fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                    title="{{ __('Remove Avatar') }}">
                                                    <i class="ki-duotone ki-cross fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="form-text">
                                                {{ __('Allowed File Types :filetypes', ['filetypes' => 'png, jpg, jpeg']) }}.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label for="full_name"
                                            class="col-lg-4 col-form-label required fw-semibold fs-6">
                                            {{ __('Full Name') }}
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="full_name" name="full_name"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ __('Full Name') }}" value="{{ $query->full_name }}"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">{{ __('Save Changes') }}</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        @can('user.destroy')
                            <div class="card mb-8 mb-xl-10">
                                <div class="card-header border-0">
                                    <div class="card-title m-0">
                                        <h3 class="fw-bold m-0">{{ __('Deactivate Account') }}</h3>
                                    </div>
                                </div>
                                <form id="form_deactivate" onsubmit="return false" novalidate="novalidate" class="form"
                                    data-url-action="{{ route('users.destroy', $query->id) }}">
                                    @method('DELETE')

                                    <div class="card-body border-top p-9">
                                        <div
                                            class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                                            <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-semibold">
                                                    <h4 class="text-gray-900 fw-bold">
                                                        {{ __('You Are Deactivating This Account') }}
                                                    </h4>
                                                    <div class="fs-6 text-gray-700">
                                                        {{ __('For Extra Security') }}.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-solid fv-row">
                                            <input type="checkbox" id="is_deactivated" name="is_deactivated"
                                                class="form-check-input" value="1" />
                                            <label for="is_deactivated" class="form-check-label fw-semibold ps-2 fs-6">
                                                {{ ucfirst(strtolower(__('I Confirm This Account Deactivation'))) }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-danger fw-semibold">
                                            {{ __('Deactivate Account') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            FormValidation.formValidation(document.querySelector("#form_profile_details"), {
                fields: {
                    full_name: {
                        validators: {
                            notEmpty: {
                                message: "Full name is required",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "is-invalid",
                        eleValidClass: "is-valid",
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                },
            }).on("core.form.valid", async function(e) {
                const form = $(e.formValidation.form);
                const actionUrl = form.data("url-action");
                const submitButton = form.find('[type="submit"]');

                submitButton.prop("disabled", true);
                await new Promise((resolve) => setTimeout(resolve, 1000));

                await $.ajax({
                    url: `${actionUrl}`,
                    type: "POST",
                    data: new FormData(form[0]),
                    enctype: "multipart/form-data",
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: async function(res) {
                        if (res.meta?.success) {
                            $.confirm({
                                theme: KTThemeMode.getMode(),
                                title: "Success!",
                                content: `${res.meta?.message ?? ""}`,
                                type: "green",
                                backgroundDismiss: true,
                                autoClose: "close|5000",
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function() {
                                            window.location.reload();
                                        },
                                    },
                                },
                            });
                        } else {
                            $.confirm({
                                theme: KTThemeMode.getMode(),
                                title: "Oops!",
                                content: `${res.meta?.message ?? ""}`,
                                type: "red",
                                backgroundDismiss: true,
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function() {},
                                    },
                                },
                            });
                        }

                        submitButton.prop("disabled", false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        const res = jQuery.parseJSON(jqXHR.responseText);
                        $.confirm({
                            theme: KTThemeMode.getMode(),
                            title: "Oops!",
                            content: `${
                                res.meta?.message ??
                                "Sorry, looks like there are some errors detected, please try again."
                            }`,
                            type: "red",
                            backgroundDismiss: true,
                            buttons: {
                                close: {
                                    text: "Close",
                                    btnClass: "btn btn-sm btn-secondary",
                                    keys: ["enter", "esc"],
                                    action: function() {},
                                },
                            },
                        });

                        submitButton.prop("disabled", false);
                    },
                });
            });

            FormValidation.formValidation(document.querySelector("#form_deactivate"), {
                fields: {
                    is_deactivated: {
                        validators: {
                            notEmpty: {
                                message: "Please check the box to deactivate this account",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "is-invalid",
                        eleValidClass: "is-valid",
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                },
            }).on("core.form.valid", async function(e) {
                const form = $(e.formValidation.form);
                const actionUrl = form.data("url-action");
                const submitButton = form.find('[type="submit"]');

                submitButton.prop("disabled", true);
                await new Promise((resolve) => setTimeout(resolve, 1000));

                await $.ajax({
                    url: `${actionUrl}`,
                    type: "POST",
                    data: new FormData(form[0]),
                    enctype: "multipart/form-data",
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: async function(res) {
                        if (res.meta?.success) {
                            $.confirm({
                                theme: KTThemeMode.getMode(),
                                title: "Success!",
                                content: `${res.meta?.message ?? ""}`,
                                type: "green",
                                autoClose: "close|5000",
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function() {
                                            window.location.reload();
                                        },
                                    },
                                },
                            });
                        } else {
                            $.confirm({
                                theme: KTThemeMode.getMode(),
                                title: "Oops!",
                                content: `${res.meta?.message ?? ""}`,
                                type: "red",
                                backgroundDismiss: true,
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function() {},
                                    },
                                },
                            });
                        }

                        submitButton.prop("disabled", false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        const res = jQuery.parseJSON(jqXHR.responseText);
                        $.confirm({
                            theme: KTThemeMode.getMode(),
                            title: "Oops!",
                            content: `${
                                res.meta?.message ??
                                "Sorry, looks like there are some errors detected, please try again."
                            }`,
                            type: "red",
                            backgroundDismiss: true,
                            buttons: {
                                close: {
                                    text: "Close",
                                    btnClass: "btn btn-sm btn-secondary",
                                    keys: ["enter", "esc"],
                                    action: function() {},
                                },
                            },
                        });

                        submitButton.prop("disabled", false);
                    },
                });
            });
        </script>
    </x-slot>
</x-main-app-layout>
