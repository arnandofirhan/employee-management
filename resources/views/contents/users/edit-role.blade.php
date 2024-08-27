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
        'name' => __('Role'),
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
                                    <h3 class="fw-bold m-0">{{ __('Roles') }}</h3>
                                </div>
                            </div>

                            <form id="form_role" onsubmit="return false" novalidate="novalidate" class="form"
                                data-url-action="{{ route('users.update.role', $query->id) }}">
                                @method('PUT')

                                <div class="card-body border-top p-9">
                                    @forelse ($roles as $item)
                                        <label
                                            class="form-check form-check-custom form-check-solid align-items-start cursor-pointer">
                                            <input type="checkbox" name="roles[]" class="form-check-input mt-3 me-3"
                                                value="{{ $item->id }}"
                                                {{ $query->hasRole($item->name) ? 'checked' : '' }} />

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

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">{{ __('Save Changes') }}</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                                <!--end::Card footer-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end:::Tab pane-->
                </div>
                <!--end:::Tab content-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>

    <x-slot name="script">
        <script>
            FormValidation.formValidation(document.querySelector("#form_role"), {
                fields: {},
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
