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
        'name' => __('Security'),
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
                                    <h3 class="fw-bold m-0">{{ __('Sign-in Method') }}</h3>
                                </div>
                            </div>

                            <div class="card-body border-top p-9">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div id="div_email_show">
                                        <div class="fs-6 fw-bold mb-1">{{ __('Email Address') }}</div>
                                        <div class="fw-semibold text-gray-600">{{ $query->email }}</div>
                                    </div>
                                    <div id="div_email_edit" class="flex-row-fluid d-none">
                                        <form id="form_email" onsubmit="return false" novalidate="novalidate"
                                            class="form"
                                            data-url-action="{{ route('users.update.email', $query->id) }}">
                                            @method('PUT')

                                            <div class="row mb-6">
                                                <div class="col-lg-12 mb-4 mb-lg-0">
                                                    <div class="fv-row mb-0">
                                                        <label for="email" class="form-label fs-6 fw-bold mb-3">
                                                            {{ __('Enter New Email Address') }}
                                                        </label>
                                                        <input type="email" id="email" name="email"
                                                            class="form-control form-control-lg form-control-solid"
                                                            value="{{ $query->email }}"
                                                            placeholder="{{ __('Email Address') }}"
                                                            autocomplete="one-time-code" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <button type="submit" id="button_email_submit"
                                                    class="btn btn-primary me-2 px-6">
                                                    {{ __('Update :name', ['name' => __('Email')]) }}
                                                </button>
                                                <button type="button" id="button_email_cancel"
                                                    class="btn btn-color-gray-500 btn-active-light-primary px-6">
                                                    {{ __('Cancel') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="ms-auto">
                                        <button id="button_email_edit_open"
                                            class="btn btn-light btn-active-light-primary">
                                            {{ __('Change Email') }}
                                        </button>
                                    </div>
                                </div>

                                <div class="separator separator-dashed my-6"></div>
                                <div class="d-flex flex-wrap align-items-center">
                                    <div id="div_password_show">
                                        <div class="fs-6 fw-bold mb-1">{{ __('Password') }}</div>
                                        <div class="fw-semibold text-gray-600">************</div>
                                    </div>
                                    <div id="div_password_edit" class="flex-row-fluid d-none">
                                        <form id="form_password" onsubmit="return false" novalidate="novalidate"
                                            class="form"
                                            data-url-action="{{ route('users.update.password', $query->id) }}">
                                            @method('PUT')

                                            <div class="row mb-1">
                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-0">
                                                        <label for="new_password" class="form-label fs-6 fw-bold mb-3">
                                                            {{ __('New Password') }}
                                                        </label>
                                                        <input type="password" id="new_password" name="password"
                                                            class="form-control form-control-lg form-control-solid"
                                                            autocomplete="one-time-code" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-0">
                                                        <label for="password_confirmation"
                                                            class="form-label fs-6 fw-bold mb-3">
                                                            {{ __('Confirm New Password') }}
                                                        </label>
                                                        <input type="password" id="password_confirmation"
                                                            name="password_confirmation"
                                                            class="form-control form-control-lg form-control-solid"
                                                            autocomplete="one-time-code" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-text mb-5">
                                                {{ __('Password Must Be At Least :requires', ['requires' => strtolower(__('8 Character')) . ' ' . strtolower(__('And')) . ' ' . strtolower(__('Contain Symbols'))]) }}
                                            </div>

                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary me-2 px-6">
                                                    {{ __('Update :name', ['name' => __('Password')]) }}
                                                </button>
                                                <button type="button" id="button_password_cancel"
                                                    class="btn btn-color-gray-500 btn-active-light-primary px-6">
                                                    {{ __('Cancel') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="ms-auto">
                                        <button id="button_password_edit_open"
                                            class="btn btn-light btn-active-light-primary">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            const handleChangeEmail = () => {
                let a = document.getElementById("button_email_edit_open");
                let b = document.getElementById("div_email_show");
                let c = document.getElementById("div_email_edit");

                a.classList.toggle("d-none");
                b.classList.toggle("d-none");
                c.classList.toggle("d-none");
            };

            const handleChangePassword = () => {
                let a = document.getElementById("button_password_edit_open");
                let b = document.getElementById("div_password_show");
                let c = document.getElementById("div_password_edit");

                a.classList.toggle("d-none");
                b.classList.toggle("d-none");
                c.classList.toggle("d-none");
            };

            $(document).on("click", `#button_email_edit_open`, async function() {
                handleChangeEmail();
            });

            $(document).on("click", `#button_email_cancel`, async function() {
                handleChangeEmail();
            });

            $(document).on("click", `#button_password_edit_open`, async function() {
                handleChangePassword();
            });

            $(document).on("click", `#button_password_cancel`, async function() {
                handleChangePassword();
            });

            FormValidation.formValidation(document.querySelector("#form_email"), {
                fields: {
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "The value is not a valid email address",
                            },
                            notEmpty: {
                                message: "Email address is required",
                            },
                        },
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "The password is required",
                            },
                            stringLength: {
                                min: 8,
                                message: "The password must be more than 8 characters long",
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

            FormValidation.formValidation(document.querySelector("#form_password"), {
                fields: {
                    current_password: {
                        validators: {
                            notEmpty: {
                                message: "Current Password is required",
                            },
                        },
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "New Password is required",
                            },
                        },
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: "Confirm Password is required",
                            },
                            identical: {
                                compare: function() {
                                    return document.getElementById("new_password").value;
                                },
                                message: "The password and its confirm are not the same",
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
