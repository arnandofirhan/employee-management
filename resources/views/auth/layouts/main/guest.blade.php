<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', config('languages')[app()->getLocale()]['code']) }}">

<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
        @if (isset($title))
            {{ $title }}
            &nbsp;─&nbsp;
        @endif
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
    <link type="text/css" rel="stylesheet" href="{{ asset('vendor/jquery-confirm/jquery-confirm.min.css') }}" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
    <!--begin::Theme mode setup on page load-->
    @include('layouts.main.partials.theme-mode')
    <!--end::Theme mode setup on page load-->

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('{{ asset('themes/main/media/auth/bg10.jpeg') }}');
            }

            [data-bs-theme="dark"] body {
                background-image: url('{{ asset('themes/main/media/auth/bg10-dark.jpeg') }}');
            }
        </style>
        <!--end::Page bg image-->

        <!--begin::App -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            @include('auth.layouts.main.partials.aside')
            <!--begin::Aside-->

            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <!--begin::Content-->
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        <!--begin::Wrapper-->
                        {{ $slot }}
                        <!--end::Wrapper-->

                        <!--begin::Footer-->
                        @include('auth.layouts.main.partials.footer')
                        <!--end::Footer-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::App-->
    </div>
    <!--end::Root-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('themes/main/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('themes/main/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('vendor/jquery-confirm/jquery-confirm.min.js') }}"></script>

    <script>
        const appLocale = `<?= app()->getLocale() ?>`;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
    </script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Additional Javascript(used for this page only)-->
    @if (isset($script))
        {{ $script }}
    @endif
    <!--end::Additional Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
