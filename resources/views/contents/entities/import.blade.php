<?php
$title = __('Import :name', ['name' => __('Entity')]);
$breadcrumbs = [
    [
        'name' => __('Entities'),
        'url' => route('entities.index'),
    ],
    [
        'name' => __('Import'),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container">
        <div class="card mb-8 mb-xl-10">
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ __('Import') }}</h3>
                </div>
            </div>

            <form id="form-validate" onsubmit="return false" novalidate="novalidate" class="form"
                data-url-action="{{ route('entities.import.validate') }}">
                @method('POST')

                <div class="card-body border-top p-9">
                    <div class="row">
                        <div class="col-sm-12 mb-5 fv-row">
                            <label for="file" class="fs-6 fw-semibold form-label required">
                                {{ __('Import File') }}
                            </label>
                            <input type="file" name="file"
                                class="form-control form-control-lg form-control-solid" />

                            <label class="mt-4">
                                Silakan unduh dan sesuaikan data yang anda miliki dengan
                                <a href="https://docs.google.com/spreadsheets/d/1MvboQ_QzriZg_63V-mN5Ji0T1mlHO2XnQ0m87siqAvg"
                                    class="badge badge-success" target="_blank">
                                    <i class="ki-outline ki-file fs-7 me-2 text-white"></i>
                                    Format Import
                                </a>
                                ini.
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div id="card_result" class="card mb-8 mb-xl-10">
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold fw-bold m-0 mt-8 mb-8">
                        {{ __('Daftar Data') }}

                        <div class="row mt-3" hidden="" div_result_note>
                            <span class="small" span_result_note></span>
                        </div>
                    </h3>
                </div>
            </div>

            <div class="card-body border-top p-0 pt-3">
                <div class="d-flex align-items-center position-relative my-1 mx-4">
                    <i class="ki-solid ki-magnifier fs-3 position-absolute ms-5"></i>
                    <input type="text" table-filter="search" class="form-control form-control-solid w-250px ps-13"
                        placeholder="{{ __('Search') }}..." />
                </div>
            </div>

            <form id="form" onsubmit="return false" novalidate="novalidate" class="form"
                data-url-action="{{ route('entities.import') }}">
                @method('POST')

                <input type="hidden" name="transaction_code" value="" transaction_code>
                <input type="hidden" name="amount" value="" amount>

                <div class="card-body p-0 py-3">
                    <table id="table-data" class="table table-responsive table-row-dashed table-hover fs-6 gs-5">
                        <thead>
                            <tr>
                                <th class="text-nowrap">No</th>
                                <th class="text-nowrap">Nama Lengkap</th>
                                <th class="text-nowrap">Jenis Kelamin</th>
                                <th class="text-nowrap">Tempat Lahir</th>
                                <th class="text-nowrap">Tanggal Lahir</th>
                                <th class="text-nowrap">NIK</th>
                                <th class="text-nowrap">Telepon</th>
                                <th class="text-nowrap">Alamat Lengkap KTP</th>
                                <th class="text-nowrap">Tanggal Bergabung</th>
                                <th class="text-nowrap">Department</th>
                                <th class="text-nowrap">Penempatan Kerja</th>
                                <th class="text-nowrap">Status Karyawan</th>
                                <th class="text-nowrap">Note</th>
                                <th class="text-nowrap">Status Import</th>
                                <th class="text-nowrap">Catatan Import</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('entities.index') }}" class="btn btn-light btn-active-light-secondary me-2">
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

    <x-slot name="style">
        <link href="{{ asset('themes/main/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
            type="text/css" />
    </x-slot>

    <x-slot name="script">
        <script src="{{ asset('themes/main/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('vendor/form-render/create.js') }}"></script>
        <script src="{{ asset('vendor/number-format/number-format.js') }}"></script>

        <script>
            const handleInitTableFilter = (filterId) => {
                const filterSearch = document.querySelector(`${filterId}`);
                return filterSearch.addEventListener("keyup", function(e) {
                    dataTable.search(e.target.value).draw();
                });
            };

            var dataTable = $(`#table-data`).DataTable({
                fixedColumns: {
                    left: 1,
                },
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Semua"]
                ],
                data: [],
                columns: [{
                        name: null,
                        data: null,
                        searchable: false,
                        orderable: false,
                        className: 'min-w-50px text-center',
                        render: function(value, type, data, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        name: "full_name",
                        data: "full_name",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-250px',
                        render: function(value, type, data, meta) {
                            if (data.full_name) {
                                return data.full_name;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "gender_category_name",
                        data: "gender_category_name",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-100px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.gender_category_name) {
                                return data.gender_category_name;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "birth_place",
                        data: "birth_place",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-100px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.birth_place) {
                                return data.birth_place;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "birth_date",
                        data: "birth_date",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-100px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.birth_date) {
                                return data.birth_date;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "identity_number",
                        data: "identity_number",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-200px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.identity_number) {
                                return data.identity_number;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "phone",
                        data: "phone",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-150px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.phone) {
                                return data.phone;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "identity_full_address",
                        data: "identity_full_address",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-750px',
                        render: function(value, type, data, meta) {
                            if (data.identity_full_address) {
                                return data.identity_full_address;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "join_date",
                        data: "join_date",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-100px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.join_date) {
                                return data.join_date;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "department_full_name",
                        data: "department_full_name",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-150px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.department_full_name) {
                                return data.department_full_name;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "job_placement",
                        data: "job_placement",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-150px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.job_placement) {
                                return data.job_placement;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "employee_status_name",
                        data: "employee_status_name",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-150px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.employee_status_name) {
                                return data.employee_status_name;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "note",
                        data: "note",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-200px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.note) {
                                return data.note;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                    {
                        name: "is_validated",
                        data: "is_validated",
                        orderable: true,
                        searchable: true,
                        className: 'min-w-100px text-center',
                        render: function(value, type, data, meta) {
                            if (value === true) {
                                return `
                                    <span class="badge bg-success text-white p-3 pt-1 pb-1">
                                        TRUE
                                    </span>
                                `;
                            } else {
                                return `
                                    <span class="badge bg-danger text-white p-3 pt-1 pb-1">
                                        FALSE
                                    </span>
                                `;
                            }
                        }
                    },
                    {
                        name: null,
                        data: null,
                        orderable: false,
                        searchable: true,
                        className: 'min-w-300px text-nowrap',
                        render: function(value, type, data, meta) {
                            if (data.notes.length) {
                                var values = [];
                                data.notes.forEach(function(value, index) {
                                    values.push(`<li class="text-nowrap">${value}</li>`);
                                });

                                return `<ol class="mb-0" style="padding-left: 1rem;">${values.join("")}</ol>`;
                            } else {
                                return `
                                    <div class="text-muted fst-italic">
                                        {{ __('None') }}
                                    </div>
                                `;
                            }
                        }
                    },
                ],
                order: [
                    [1, "asc"],
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                },
            });

            $(document).on('change', `[name="file"]`, async function() {
                const waitScreen = await handleWaitScreen(`#form-validate`);

                $(`[amount]`).val('');
                $(`[transaction_code]`).val('');
                $(`[span_result_note]`).html('');
                $(`[div_result_note]`).prop('hidden', true);

                await dataTable.clear();
                await dataTable.rows.add([]);
                await dataTable.draw();
                await new Promise(resolve => setTimeout(resolve, 1000));

                const form = $(`#form-validate`);
                const actionUrl = form.data("url-action");
                await $.ajax({
                    url: `${actionUrl}`,
                    type: "POST",
                    data: new FormData(form[0]),
                    enctype: 'multipart/form-data',
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: async function(res) {
                        if (res.meta?.success) {
                            dataTable.clear();
                            dataTable.rows.add(res.data.data);
                            dataTable.draw();

                            $(`[amount]`).val(res.data.true_amount);
                            $(`[transaction_code]`).val(res.data.transaction_code);
                            $(`[button-save]`).prop('disabled', false);

                            $(`[div_result_note]`).prop('hidden', false);
                            $(`[span_result_note]`).html(
                                `Terdapat <span class="badge bg-primary text-white">${handleNumberFormat(appLocale, res.data.total_amount, 0)} data</span>${res.data.true_amount == res.data.total_amount ? ` dan <span class="badge bg-success text-white">semua data</span> adalah data yang benar` : `, dimana <span class="badge bg-success text-white">${handleNumberFormat(appLocale, res.data.true_amount, 0)} data</span> adalah data yang benar dan <span class="badge bg-danger text-white">${handleNumberFormat(appLocale, res.data.false_amount, 0)} data</span> adalah data yang salah`}.`
                            );
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

                        waitScreen.release();
                        waitScreen.destroy();
                        $(`[name="file"]`).val(null);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        const res = jQuery.parseJSON(jqXHR.responseText);
                        $.confirm({
                            theme: KTThemeMode.getMode(),
                            title: "Oops!",
                            content: `${ res.meta?.message ?? "Sorry, looks like there are some errors detected, please try again." }`,
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

                        waitScreen.release();
                        waitScreen.destroy();
                        $(`[name="file"]`).val(null);
                    }
                });
            });

            handleInitTableFilter(`[table-filter="search"]`);
            handleInitCreate(`#form`, {}, {
                index: {
                    text: "Back to list",
                    btnClass: "btn btn-sm btn-secondary",
                    action: function() {
                        window.location.replace(`{{ route('entities.index') }}`);
                    },
                },
                reImport: {
                    text: "Re-import",
                    btnClass: "btn btn-sm btn-primary",
                    action: function() {
                        window.location.reload();
                    },
                },
            });
        </script>
    </x-slot>
</x-main-app-layout>
