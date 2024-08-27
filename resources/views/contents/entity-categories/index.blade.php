<?php
$title = __('Entity Categories');
$breadcrumbs = [
    [
        'name' => __('Entity Categories'),
        'url' => route('entity-categories.index'),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container">
        <div class="card">
            <div class="card-header border-0 px-7 py-3">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-solid ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" table-filter="search" class="form-control form-control-solid w-250px ps-13"
                            placeholder="{{ __('Search') }}..." />
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
        <script src="{{ asset('themes/main/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('vendor/datatables/table-filter.js') }}"></script>
        {{ $dataTable->scripts() }}

        <script>
            handleInitTableFilter(`table_entity_category`, `[table-filter="search"]`);
        </script>
    </x-slot>
</x-main-app-layout>
