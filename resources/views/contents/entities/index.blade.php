<?php
$title = __('Entities');
$breadcrumbs = [
    [
        'name' => __('Entities'),
        'url' => route('entities.index'),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container">
        <div id="div_advanced_search" class="card mb-8 mb-xl-10">
            <div class="card-header border-0 px-7 py-4 min-h-50px">
                <div class="card-title">
                    <h3 class="fw-bold m-0">{{ __('Advanced Search') }}</h3>
                </div>
            </div>

            <form id="form_advanced_search" onsubmit="return false" novalidate="novalidate" class="form"
                data-url-action="{{ route('entities.index') }}">
                @method('PUT')

                <div class="card-body p-6 pt-0 pb-0">
                    <div class="row">
                        <div class="col-sm-3 mb-6 fv-row">
                            <input type="text" id="full_name" name="full_name"
                                class="form-control form-control-md form-control-solid" value=""
                                placeholder="{{ __('Full Name') }}" autocomplete="one-time-code" />
                        </div>
                        <div class="col-sm-3 mb-6 fv-row">
                            <select name="gender_category" class="form-select form-select-solid" data-control="select2"
                                aria-label="Select a gender category" data-placeholder="Semua" data-hide-search="true"
                                data-allow-clear="true">
                                <option value="">Semua</option>
                                <option value="{{ App\Constants\GenderCategoryConstant::MALE }}">
                                    Laki-Laki
                                </option>
                                <option value="{{ App\Constants\GenderCategoryConstant::FEMALE }}">
                                    Perempuan
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-3 mb-6 fv-row">
                            <input id="departments" name="departments"
                                class="form-control form-control-md form-control-solid p-3" value=""
                                placeholder="{{ __('Department') }}" autocomplete="one-time-code" />
                        </div>
                        <div class="col-sm-3 mb-6 fv-row">
                            <input id="employee_statuses" name="employee_statuses"
                                class="form-control form-control-md form-control-solid p-3" value=""
                                placeholder="{{ __('Employee Status') }}" autocomplete="one-time-code" />
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-start px-6 py-0 mb-6 border-top-0">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <span class="indicator-label">{{ __('Terapkan Pencarian') }}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <div id="div_result" class="card">
            <div class="card-header border-0 px-7 py-3">
                <div class="card-title"></div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end">
                        @can('entity.create')
                            <a class="btn btn-primary" href="{{ route('entities.create') }}">
                                <i class="ki-solid ki-plus fs-2"></i>
                                {{ __('Create') }}
                            </a>
                        @endcan

                        @can('entity.import')
                            <a class="btn btn-primary @can('entity.create') ms-4 @endcan"
                                href="{{ route('entities.import') }}">
                                <i class="ki-solid ki-plus fs-2"></i>
                                {{ __('Import') }}
                            </a>
                        @endcan

                        @can('entity.export')
                            <a class="btn btn-primary @can('entity.create') ms-4 @endcan"
                                href="{{ url('/export-employees') }}">
                                <i class="ki-solid ki-plus fs-2"></i>
                                {{ __('Export') }}
                            </a>
                        @endcan

                    </div>
                </div>
            </div>
            <div class="card-body p-0 py-3">
                {{ $dataTable->table(['class' => 'table table-responsive table-row-dashed table-hover fs-6 gs-5 align-middle']) }}
            </div>
        </div>
    </div>

    <x-slot name="style">
        <link type="text/css" rel="stylesheet"
            href="{{ asset('themes/main/plugins/custom/datatables/datatables.bundle.css') }}" />
    </x-slot>

    <x-slot name="script">
        <script>
            var indexUrl = `{{ route('entities.index') }}`;
            var tableId = `table_entity`;
        </script>

        <script src="{{ asset('themes/main/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('vendor/form-render/delete.js') }}"></script>
        <script src="{{ asset('vendor/form-render/select.js') }}"></script>
        {{ $dataTable->scripts() }}

        <script>
            new Tagify(document.querySelector('#departments'), {
                tagTextProp: 'full_name',
                enforceWhitelist: true,
                skipInvalid: false,
                dropdown: {
                    closeOnSelect: false,
                    enabled: 0,
                    searchKeys: [
                        'full_name',
                    ]
                },
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.id).join(','),
                templates: {
                    tag: function(tagData) {
                        return `
                            <tag title="${tagData.full_name}"
                                    contenteditable='false'
                                    spellcheck='false'
                                    tabIndex="-1"
                                    class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
                                    ${this.getAttributes(tagData)}>
                                <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                                <div class="d-flex align-items-center">
                                    <span class='tagify__tag-text fs-8'>${tagData.full_name}</span>
                                </div>
                            </tag>
                        `;
                    },
                    dropdownItem: function(tagData) {
                        return `
                            <div ${this.getAttributes(tagData)}
                                class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
                                tabindex="0"
                                role="option">
                                <div class="d-flex flex-column">
                                    <strong>${tagData.full_name}</strong>
                                </div>
                            </div>
                        `;
                    },
                },
                whitelist: {!! $departments->toJson() !!}.map(function(item) {
                    item.value = item.id;
                    return item;
                }),
            });

            new Tagify(document.querySelector('#employee_statuses'), {
                tagTextProp: 'name',
                enforceWhitelist: true,
                skipInvalid: false,
                dropdown: {
                    maxItems: 50,
                    closeOnSelect: false,
                    enabled: 0,
                    searchKeys: [
                        'name',
                    ]
                },
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.id).join(','),
                templates: {
                    tag: function(tagData) {
                        return `
                            <tag title="${tagData.name}"
                                    contenteditable='false'
                                    spellcheck='false'
                                    tabIndex="-1"
                                    class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
                                    ${this.getAttributes(tagData)}>
                                <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                                <div class="d-flex align-items-center">
                                    <span class='tagify__tag-text fs-8'>${tagData.name}</span>
                                </div>
                            </tag>
                        `;
                    },
                    dropdownItem: function(tagData) {
                        return `
                            <div ${this.getAttributes(tagData)}
                                class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
                                tabindex="0"
                                role="option">
                                <div class="d-flex flex-column">
                                    <strong>${tagData.name}</strong>
                                </div>
                            </div>
                        `;
                    },
                },
                whitelist: {!! $employeeStatuses->toJson() !!}.map(function(item) {
                    item.value = item.id;
                    return item;
                }),
            });

            FormValidation.formValidation(document.querySelector("#form_advanced_search"), {
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
                const formElement = $(e.formValidation.form);
                const actionUrl = formElement.attr("data-url-action");
                const submitButton = formElement.find('[type="submit"]');
                const divElement = formElement.closest('.card');

                await submitButton.prop("disabled", true);
                await submitButton.attr("data-kt-indicator", "on");

                const waitScreen = await handleWaitScreen(divElement);
                const resultWaitScreen = await handleWaitScreen(`#div_result`);
                await new Promise((resolve) => setTimeout(resolve, 1000));

                var parameters = [];
                parameters['full_name'] = String(formElement.find(`[name="full_name"]`).val()).replaceAll('&');
                parameters['gender_category'] = String(formElement.find(`[name="gender_category"]`).val())
                    .replaceAll('&');
                parameters['departments'] = String(formElement.find(`[name="departments"]`).val())
                    .replaceAll('&');
                parameters['employee_statuses'] = String(formElement.find(`[name="employee_statuses"]`).val())
                    .replaceAll('&');

                var parameterAndValue = '';
                Object.keys(parameters).forEach((key, index) => {
                    parameterAndValue += `${key}=${parameters[key] ?? ''}`;
                    if (index != Object.keys(parameters).length - 1) {
                        parameterAndValue += '&';
                    }
                });

                await window.LaravelDataTables[tableId].ajax.url(
                    `<?= url()->full() ?>?${parameterAndValue}`
                ).load();

                submitButton.prop("disabled", false);
                submitButton.removeAttr("data-kt-indicator");
                waitScreen.release();
                waitScreen.destroy();
                resultWaitScreen.release();
                resultWaitScreen.destroy();
            });
        </script>
    </x-slot>
</x-main-app-layout>
