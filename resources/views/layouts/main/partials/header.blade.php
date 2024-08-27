<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}"
    data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}"
    data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div id="kt_app_header_container"
        class="app-container container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Sidebar mobile toggle-->
        <div id="kt_app_sidebar_mobile_toggle" class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2"
            title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--end::Sidebar mobile toggle-->

        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <div class="d-lg-none">
                <img alt="Logo" src="{{ asset(config('app.landscape_light_image_url')) }}"
                    class="h-25px theme-light-show" />
                <img alt="Logo" src="{{ asset(config('app.landscape_dark_image_url')) }}"
                    class="h-25px theme-dark-show" />
            </div>
        </div>
        <!--end::Mobile logo-->

        <!--begin::Header wrapper-->
        <div id="kt_app_header_wrapper" class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Current time -->
            <div class="d-flex align-items-center overflow-auto">
                <!--begin::Current time -->
                <div id="current-time"
                    class="position-relative my-1 fs-6 fs-md-4 fst-italic text-gray-700 text-end text-md-start">
                    <x-date-format :date="date('Y-m-d H:i:s')" format='l, j F Y' />&nbsp;
                    <x-date-format :date="date('Y-m-d H:i:s')" format='H:i:s' />
                </div>
                <!--end::Current time -->
            </div>
            <!--end::Current time -->

            <!--begin::Navbar-->
            @include('layouts.main.partials.navbar')
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
