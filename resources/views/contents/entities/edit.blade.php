<?php
$title = __('Edit :name', ['name' => $query->full_name]);
$breadcrumbs = [
    [
        'name' => __('Entities'),
        'url' => route('entities.index'),
    ],
    [
        'name' => __('Edit :name', ['name' => $query->full_name]),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container">
        <div class="card mb-8 mb-xl-10">
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ __('Edit :name', ['name' => $query->full_name]) }}</h3>
                </div>
            </div>

            <form id="form" onsubmit="return false" novalidate="novalidate" class="form"
                data-url-action="{{ route('entities.update', $query->id) }}">
                @method('PUT')

                <div class="card-body border-top p-9">
                    <div class="d-none row">
                        <div class="col-sm-12 mb-7 fv-row">
                            <label for="is_active" class="fs-6 fw-semibold form-label">
                                {{ __('Status') }}
                            </label>
                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                <input type="checkbox" id="is_active" name="status" class="form-check-input w-50px"
                                    value="1" {{ $query->is_active ? 'checked' : '' }} />
                                <label class="form-check-label cursor-pointer" for="is_active">
                                    {{ __('Is Active :name', ['name' => strtolower(__('Entity'))]) }}
                                </label>
                            </div>
                        </div>
                        <div class="d-none col-sm-6 mb-7 fv-row">
                            <label for="entity_categories" class="fs-6 fw-semibold form-label">
                                {{ __('Entity Categories') }}
                            </label>

                            @forelse ($entityCategories as $item)
                                <div class="form-check form-check-custom form-check-solid form-check-sm mt-2 mb-2">
                                    <input type="checkbox" id="entity_category_{{ $item->id }}"
                                        name="entity_categories[]" class="form-check-input cursor-pointer"
                                        value="{{ $item->id }}"
                                        {{ $query->entityCategories->contains('id', $item->id) ? 'checked' : '' }} />
                                    <label for="entity_category_{{ $item->id }}"
                                        class="form-check-label cursor-pointer"
                                        style="color: {{ $item->background_color_code }}">
                                        {{ $item->name }}
                                    </label>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-7 fv-row">
                            <label for="full_name" class="fs-6 fw-semibold form-label required">
                                {{ __('Full Name') }}
                            </label>
                            <input type="text" name="full_name"
                                class="form-control form-control-lg form-control-solid" value="{{ $query->full_name }}"
                                placeholder="{{ __('Full Name') }}" autocomplete="one-time-code" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-2 mb-7 fv-row">
                            <label for="gender_category" class="fs-6 fw-semibold form-label required">
                                {{ __('Jenis Kelamin') }}
                            </label>
                            <select name="gender_category" class="form-select form-select-solid" data-control="select2"
                                aria-label="Select a category" data-placeholder="Select category"
                                data-hide-search="true">
                                <option value="{{ App\Constants\GenderCategoryConstant::MALE }}"
                                    {{ $query->gender_category === App\Constants\GenderCategoryConstant::MALE ? 'selected' : '' }}>
                                    Laki-Laki
                                </option>
                                <option value="{{ App\Constants\GenderCategoryConstant::FEMALE }}"
                                    {{ $query->gender_category === App\Constants\GenderCategoryConstant::FEMALE ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mb-7 fv-row">
                            <label for="birth_place" class="fs-6 fw-semibold form-label required">
                                {{ __('Tempat Lahir') }}
                            </label>
                            <input type="text" name="birth_place"
                                class="form-control form-control-lg form-control-solid"
                                value="{{ $query->birth_place }}" placeholder="{{ __('Tempat Lahir') }}"
                                autocomplete="one-time-code" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mb-7 fv-row">
                            <label for="birth_date" class="fs-6 fw-semibold form-label required">
                                {{ __('Tanggal Lahir') }}
                            </label>
                            <input type="text" name="birth_date"
                                class="form-control form-control-lg form-control-solid form-date"
                                value="{{ $query->birth_date }}" placeholder="{{ __('Tanggal Lahir') }}"
                                autocomplete="one-time-code" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-7 fv-row">
                            <label for="identity_number" class="fs-6 fw-semibold form-label required">
                                {{ __('Nomor Induk Kependudukan') }}
                            </label>
                            <input type="text" name="identity_number"
                                class="form-control form-control-lg form-control-solid"
                                value="{{ $query->identity_number }}"
                                placeholder="{{ __('Nomor Induk Kependudukan') }}" autocomplete="one-time-code" />
                        </div>
                        <div class="col-sm-6 mb-7 fv-row">
                            <label for="phone" class="fs-6 fw-semibold form-label required">
                                {{ __('Telepon') }}
                            </label>
                            <input type="text" name="phone" class="form-control form-control-lg form-control-solid"
                                value="{{ $query->phone }}" placeholder="{{ __('Telepon') }}"
                                autocomplete="one-time-code" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-7 fv-row">
                            <label for="identity_full_address" class="fs-6 fw-semibold form-label required">
                                {{ __('Alamat Lengkap KTP') }}
                            </label>
                            <textarea name="identity_full_address" class="form-control form-control-lg form-control-solid"
                                placeholder="{{ __('Full Address') }}" autocomplete="one-time-code" data-kt-autosize="true" maxlength="150">{{ $query->identity_full_address }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-3 mb-7 fv-row">
                            <label for="join_date" class="fs-6 fw-semibold form-label required">
                                {{ __('Tanggal Bergabung') }}
                            </label>
                            <input type="text" name="join_date"
                                class="form-control form-control-lg form-control-solid form-date"
                                value="{{ $query->join_date }}" placeholder="{{ __('Tanggal Bergabung') }}"
                                autocomplete="one-time-code" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mb-7 fv-row">
                            <label for="department" class="fs-6 fw-semibold form-label required">
                                {{ __('Department') }}
                            </label>
                            <select name="department" class="form-select form-select-solid"
                                aria-label="Select a department" data-placeholder="Select department">
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mb-7 fv-row">
                            <label for="job_placement" class="fs-6 fw-semibold form-label required">
                                {{ __('Lokasi Penempatan Kerja') }}
                            </label>
                            <input type="text" name="job_placement"
                                class="form-control form-control-lg form-control-solid"
                                value="{{ $query->job_placement }}"
                                placeholder="{{ __('Lokasi Penempatan Kerja') }}" autocomplete="one-time-code" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mb-7 fv-row">
                            <label for="employee_status" class="fs-6 fw-semibold form-label required">
                                {{ __('Employee Status') }}
                            </label>
                            <select name="employee_status" class="form-select form-select-solid"
                                data-control="select2" aria-label="Select a employee status"
                                data-placeholder="Select employee status" data-hide-search="true">
                                @forelse ($employeeStatuses as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id === $query->employee_status_id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @empty
                                    <option value=""></option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-7 fv-row">
                            <label for="note" class="fs-6 fw-semibold form-label">
                                {{ __('Note') }}
                            </label>

                            <textarea name="note" class="form-control form-control-lg form-control-solid" placeholder="{{ __('Note') }}"
                                autocomplete="one-time-code" data-kt-autosize="true" maxlength="150">{{ $query->note }}</textarea>
                        </div>
                    </div>
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

    <x-slot name="script">
        <script src="{{ asset('vendor/form-render/edit.js') }}"></script>
        <script src="{{ asset('vendor/form-render/select.js') }}"></script>
        <script src="{{ asset('vendor/time-format/time-format.js') }}"></script>

        <script>
            handleInitSelectEntity(`{{ route('api.departments.index') }}`, `[name="department"]`);

            tempusDominus.extend(tempusDominus.plugins.customDateFormat);
            const handelGenerateInputDate = (paramenter) => {
                Inputmask({
                    "mask": "9999-99-99"
                }).mask(paramenter);

                $(paramenter).map((index, item) => {
                    new tempusDominus.TempusDominus(item, {
                        localization: {
                            locale: "id",
                            format: "yyyy-MM-dd",
                        },
                        display: {
                            components: {
                                clock: false
                            }
                        },
                    });
                });
            }

            handleInitEdit(`#form`, {
                full_name: {
                    validators: {
                        notEmpty: {
                            message: "Full name is required",
                        },
                    },
                },
                gender_category: {
                    validators: {
                        notEmpty: {
                            message: "The gender category is required",
                        },
                    },
                },
                birth_place: {
                    validators: {
                        notEmpty: {
                            message: "The birth of place is required",
                        },
                    },
                },
                birth_date: {
                    validators: {
                        notEmpty: {
                            message: "The birth date is required",
                        },
                    },
                },
                identity_number: {
                    validators: {
                        notEmpty: {
                            message: "The identity number is required",
                        },
                    },
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: "The phone is required",
                        },
                    },
                },
                identity_full_address: {
                    validators: {
                        notEmpty: {
                            message: "The full address of identity is required",
                        },
                    },
                },
                join_date: {
                    validators: {
                        notEmpty: {
                            message: "The joining date is required",
                        },
                    },
                },
                department: {
                    validators: {
                        notEmpty: {
                            message: "The department is required",
                        },
                    },
                },
                job_placement: {
                    validators: {
                        notEmpty: {
                            message: "The employee status is required",
                        },
                    },
                },
                employee_status: {
                    validators: {
                        notEmpty: {
                            message: "The employee status is required",
                        },
                    },
                },
            });

            handelGenerateInputDate(`.form-date`);
            @if ($query->department)
                $(`[name="department"]`).select2("trigger", "select", {
                    data: {
                        id: `{{ $query->department->id }}`,
                        text: `{{ $query->department->full_name }}`,
                        data: {!! $query->department->toJson() !!}
                    }
                });
            @endif
        </script>
    </x-slot>
</x-main-app-layout>
