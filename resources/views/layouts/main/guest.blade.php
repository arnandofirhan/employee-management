<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', config('languages')[app()->getLocale()]['code']) }}">

<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        @yield('title')
        &nbsp;─&nbsp;
        {{ config('app.full_name') }}
    </title>
    <link rel="canonical" href="https://membasuh.com" />
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_url')) }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link type="text/css" rel="stylesheet" href="{{ asset('themes/main/plugins/global/plugins.bundle.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('themes/main/css/style.bundle.css') }}" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    @include('layouts.main.partials.theme-mode')
    <!--end::Theme mode setup on page load-->

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            {{ $slot }}
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>
    <!--end::Root-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('themes/main/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('themes/main/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
