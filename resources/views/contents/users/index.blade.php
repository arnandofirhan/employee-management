<?php
$title = __('Users');
$breadcrumbs = [
    [
        'name' => __('Users'),
        'url' => route('users.index'),
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

                @can('user.create')
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-primary" href="{{ route('users.create') }}">
                                <i class="ki-solid ki-plus fs-2"></i>
                                {{ __('Create') }}
                            </a>
                        </div>
                    </div>
                @endcan
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
            var indexUrl = `{{ route('users.index') }}`;
            var tableId = `table_user`;
        </script>

        <script src="{{ asset('themes/main/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('vendor/datatables/table-filter.js') }}"></script>
        <script src="{{ asset('vendor/form-render/delete.js') }}"></script>
        {{ $dataTable->scripts() }}

        <script>
            handleInitTableFilter(tableId, `[table-filter="search"]`);
        </script>
    </x-slot>
</x-main-app-layout>
