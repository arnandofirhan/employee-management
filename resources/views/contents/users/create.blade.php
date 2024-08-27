<?php
$title = __('Create :name', ['name' => __('User')]);
$breadcrumbs = [
    [
        'name' => __('User'),
        'url' => route('users.index'),
    ],
    [
        'name' => __('Create'),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container">
        <div id="div_create_account_stepper"
            class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10">
            <div
                class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px">
                <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
                    <div class="stepper-nav">
                        <div data-kt-stepper-element="nav" class="stepper-item current">
                            <div class="stepper-wrapper">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">{{ __('Personal Info') }}</h3>
                                    <div class="stepper-desc fw-semibold">
                                        {{ ucfirst(strtolower(__('Personal Related Info'))) }}
                                    </div>
                                </div>
                            </div>
                            <div class="stepper-line h-40px"></div>
                        </div>

                        <div data-kt-stepper-element="nav" class="stepper-item">
                            <div class="stepper-wrapper">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">{{ __('Account Details') }}</h3>
                                    <div class="stepper-desc fw-semibold">
                                        {{ ucfirst(strtolower(__('Setup Account Details'))) }}
                                    </div>
                                </div>
                            </div>
                            <div class="stepper-line h-40px"></div>
                        </div>

                        <div data-kt-stepper-element="nav" class="stepper-item">
                            <div class="stepper-wrapper">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">{{ __('Roles') }}</h3>
                                    <div class="stepper-desc fw-semibold">
                                        {{ ucfirst(strtolower(__('Setup Roles'))) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card d-flex flex-row-fluid flex-center">
                <form id="form_create_account" onsubmit="return false" novalidate="novalidate"
                    class="card-body py-20 w-100 px-9" data-url-action="{{ route('users.store') }}">
                    <div data-kt-stepper-element="content" class="current">
                        <div class="w-100">
                            <div class="pb-10 pb-lg-12">
                                <h2 class="fw-bold text-gray-900">{{ __('Personal Info') }}</h2>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mb-10 fv-row">
                                    <label class="fs-6 fw-semibold form-label">
                                        {{ __('Status') }}
                                    </label>
                                    <div
                                        class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                        <input type="checkbox" id="is_active" name="status"
                                            class="form-check-input w-50px" value="1" checked="" />
                                        <label class="form-check-label cursor-pointer" for="is_active">
                                            {{ __('Is Active :name', ['name' => strtolower(__('Account'))]) }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 mb-10 fv-row">
                                    <label class="fs-6 fw-semibold form-label required">
                                        {{ __('Full Name') }}
                                    </label>
                                    <input type="text" name="full_name"
                                        class="form-control form-control-lg form-control-solid" value=""
                                        placeholder="{{ __('Full Name') }}" autocomplete="one-time-code" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-kt-stepper-element="content">
                        <div class="w-100">
                            <div class="pb-10 pb-lg-12">
                                <h2 class="fw-bold text-gray-900">{{ __('Account Details') }}</h2>
                            </div>
                            <div class="fv-row mb-10">
                                <label for="email" class="fs-6 fw-semibold form-label required">
                                    {{ __('Email') }}
                                </label>
                                <input type="text" id="email" name="email"
                                    class="form-control form-control-lg form-control-solid" value=""
                                    placeholder="{{ __('Email') }}" autocomplete="one-time-code" />
                            </div>

                            <div class="row mb-10">
                                <div class="col-md-6 fv-row">
                                    <label for="password" class="fs-6 fw-semibold form-label required">
                                        {{ __('Password') }}
                                    </label>
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg form-control-solid" value=""
                                        placeholder="{{ __('Password') }}" autocomplete="one-time-code" />
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label for="password_confirmation" class="fs-6 fw-semibold form-label required">
                                        {{ __('Confirm Password') }}
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control form-control-lg form-control-solid" value=""
                                        placeholder="{{ __('Confirm Password') }}" autocomplete="one-time-code" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-kt-stepper-element="content">
                        <div class="w-100">
                            <div class="pb-10 pb-lg-15">
                                <h2 class="fw-bold text-gray-900">{{ __('Roles') }}</h2>
                            </div>
                            <div class="d-flex flex-column mb-7 fv-row">
                                @forelse ($roles as $item)
                                    <label
                                        class="form-check form-check-custom form-check-solid align-items-start cursor-pointer">
                                        <input type="checkbox" name="roles[]" class="form-check-input mt-3 me-3"
                                            value="{{ $item->id }}" />

                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fw-bold fs-5 mb-0">{{ $item->name }}</span>
                                            <span class="text-muted fs-6">
                                                <span class="text-nowrap">
                                                    {!! $item->permissions->sortBy('name')->pluck('name')->join('<span class="h5">,</span></span> <span class="text-nowrap">') !!}
                                                </span>
                                            </span>
                                        </span>
                                    </label>

                                    @if ($loop->last === false)
                                        <div class="separator separator-dashed my-5"></div>
                                    @endif
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-stack pt-10">
                        <div class="mr-2">
                            <button type="button" class="btn btn-lg btn-light-primary me-3"
                                data-kt-stepper-action="previous">
                                <i class="ki-duotone ki-arrow-left fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ __('Back') }}
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-lg btn-primary me-3"
                                data-kt-stepper-action="submit">
                                <span class="indicator-label">
                                    {{ __('Submit') }}
                                    <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="indicator-progress">
                                    {{ __('Please Wait') }}...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                {{ __('Continue') }}
                                <i class="ki-duotone ki-arrow-right fs-4 ms-1 me-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            var t = document.querySelector("#div_create_account_stepper");
            var i = t.querySelector("#form_create_account");
            var o = t.querySelector('[data-kt-stepper-action="submit"]');
            var a = t.querySelector('[data-kt-stepper-action="next"]');
            var r = new KTStepper(t);
            var s = [];

            r.on("kt.stepper.next", function(e) {
                var currentStepIndex = s[e.getCurrentStepIndex() - 1];
                if (currentStepIndex) {
                    currentStepIndex.validate().then(function(t) {
                        if ("Valid" == t) {
                            e.goNext();
                            KTUtil.scrollTop();
                        }
                    });
                } else {
                    e.goNext();
                    KTUtil.scrollTop();
                }
            });

            r.on("kt.stepper.previous", function(e) {
                e.goPrevious();
                KTUtil.scrollTop();
            });

            s.push(
                FormValidation.formValidation(i, {
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
                    },
                })
            );

            s.push(
                FormValidation.formValidation(i, {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {
                                    message: "Email address is required",
                                },
                                regexp: {
                                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: "The value is not a valid email address",
                                },
                            },
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "Password is required",
                                },
                                stringLength: {
                                    min: 8,
                                    message: "The password must be more than 8 characters long",
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
                                        return document.getElementById("password").value;
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
                    },
                })
            );

            s.push(
                FormValidation.formValidation(i, {
                    fields: {},
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "is-invalid",
                            eleValidClass: "is-valid",
                        }),
                    },
                })
            );

            o.addEventListener("click", function(e) {
                const form = $(this).closest("form");
                const actionUrl = form.data("url-action");
                const submitButton = $(this);

                s[s.length - 1].validate().then(async function(t) {
                    if ("Valid" == t) {
                        submitButton.prop("disabled", true);
                        submitButton.attr("data-kt-indicator", "on");
                        await new Promise((resolve) => setTimeout(resolve, 2000));

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
                                        buttons: {
                                            index: {
                                                text: "Back to list",
                                                btnClass: "btn btn-sm btn-secondary",
                                                action: function() {
                                                    window.location.replace(
                                                        `${actionUrl}`);
                                                },
                                            },
                                            reCreate: {
                                                text: "Recreate",
                                                btnClass: "btn btn-sm btn-primary",
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
                                submitButton.removeAttr("data-kt-indicator");
                            },
                        });
                    } else {
                        $.confirm({
                            theme: KTThemeMode.getMode(),
                            title: "Oops!",
                            content: "Sorry, looks like there are some errors detected, please try again.",
                            type: "red",
                            buttons: {
                                close: {
                                    text: "Close",
                                    btnClass: "btn btn-sm btn-secondary",
                                    keys: ["enter", "esc"],
                                    action: function() {
                                        KTUtil.scrollTop();
                                    },
                                },
                            },
                        });
                    }
                });
            });
        </script>
    </x-slot>
</x-main-app-layout>
