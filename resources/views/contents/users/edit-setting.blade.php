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
    [
        'name' => __('Setting'),
        'url' => null,
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
                                    <h3 class="fw-bold m-0">{{ __('Settings') }}</h3>
                                </div>
                            </div>

                            <form id="form_setting" onsubmit="return false" novalidate="novalidate" class="form"
                                data-url-action="{{ route('users.update.setting', $query->id) }}">
                                @method('PUT')

                                <div class="card-body border-top p-9">
                                    <div class="row mb-6">
                                        <label for="entity" class="col-lg-4 col-form-label fw-semibold fs-6">
                                            {{ __('Entity') }}
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <select name="entity" class="form-select form-select-solid"
                                                aria-label="Select an entity" data-placeholder="Select entity">
                                            </select>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('vendor/form-render/select.js') }}"></script>

        <script>
            handleInitSelectEntity(`{{ route('api.entities.index') }}`, `[name="entity"]`, true);

            @if ($query->userSetting?->entity)
                $(`[name="entity"]`).select2("trigger", "select", {
                    data: {
                        id: `{{ $query->userSetting->entity->id }}`,
                        text: `{{ $query->userSetting->entity->full_name }}`,
                        data: {!! $query->userSetting->entity->toJson() !!}
                    }
                });
            @endif

            FormValidation.formValidation(document.querySelector("#form_setting"), {
                fields: {
                    // entity: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: "Entity is required",
                    //         },
                    //     },
                    // },
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
        </script>
    </x-slot>
</x-main-app-layout>
