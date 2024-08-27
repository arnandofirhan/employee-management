<?php
$title = __('Profile');
$breadcrumbs = [
    [
        'name' => __('Profile'),
        'url' => route('profile.index'),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="mt-9 app-container">
        @include('profile.partials.header')

        <div id="kt_profile_details_view" class="card">
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ __('Profile Details') }}</h3>
                </div>

                @can('auth.edit')
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary align-self-center">
                        {{ __('Edit :name', ['name' => __('Profile')]) }}
                    </a>
                @endcan
            </div>

            <div class="card-body border-top p-9">
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">
                        {{ __('Full Name') }}
                    </label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ auth()->user()->full_name }}</span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">
                        {{ __('Email') }}
                    </label>

                    <div class="col-lg-8 d-flex align-items-center">
                        <a href="mailto:{{ auth()->user()->email }}"
                            class="fw-bold fs-6 text-gray-800 text-hover-primary me-2">{{ auth()->user()->email }}</a>
                        {{-- <span class="badge badge-success">Verified</span> --}}
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">{{ __('Roles') }}</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">
                            {!! $query->getRoleNames()->toArray()
                                ? implode(', ', $query->getRoleNames()->toArray())
                                : '<span class="text-muted fw-light fst-italic">' . __('general.none') . '</span>' !!}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-app-layout>
