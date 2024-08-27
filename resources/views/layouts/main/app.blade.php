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

    <style>
        .heart-svg {
            fill: red;
            position: relative;
            top: -1px;
            height: 6pt;
            animation: pulse 1s ease infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Additional Stylesheets(used for this page only)-->
    @if (isset($style))
        {{ $style }}
    @endif
    <!--end::Additional Stylesheets-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-toolbar-fixed="true"
    {{-- data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on" --}}
    data-kt-app-sidebar-minimize="{{ isset($_COOKIE['sidebar_minimize_state']) && $_COOKIE['sidebar_minimize_state'] === 'on' ? 'on' : 'off' }}"
    class="app-default">

    <!--begin::Theme mode setup on page load-->
    @include('layouts.main.partials.theme-mode')
    <!--end::Theme mode setup on page load-->

    <!--begin::loader-->
    <div class="app-page-loader flex-column">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-muted fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <!--end::Loader-->

    <!--begin::App-->
    <div id="kt_app_root" class="d-flex flex-column flex-root app-root">
        <!--begin::Page-->
        <div id="kt_app_page" class="app-page flex-column flex-column-fluid">
            <!--begin::Header-->
            @include('layouts.main.partials.header')
            <!--end::Header-->

            <!--begin::Wrapper-->
            <div id="kt_app_wrapper" class="app-wrapper flex-column flex-row-fluid">
                <!--begin::Sidebar-->
                @include('layouts.main.partials.sidebar')
                <!--end::Sidebar-->

                <!--begin::Main-->
                <div id="kt_app_main" class="app-main flex-column flex-row-fluid">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Toolbar-->
                        @include('layouts.main.partials.toolbar')
                        <!--end::Toolbar-->

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            {{ $slot }}
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->

                    <!--begin::Footer-->
                    @include('layouts.main.partials.footer')
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    {{--
    <!--begin::Drawers-->
    @include('layouts.main.partials.drawer')
    <!--end::Drawers-->
    --}}

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Modals-->
    <div id="modal_image" class="modal modal-md fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pt-4 pb-4">
                    <h3 id="modal_image_title" class="modal-title">Image Preview</h3>

                    <div class="btn btn-icon btn-sm btn-light btn-active-secondary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="d-flex flex-center">
                        <img id="modal_image_img" src="{{ asset('themes/main/media/misc/spinner.gif') }}"
                            data-src="{{ asset('themes/main/media/misc/spinner.gif') }}" class="lozad rounded mw-100"
                            alt="" data-loaded="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($modal))
        {{ $modal }}
    @endif
    <!--end::Modals-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('themes/main/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('themes/main/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('themes/main/js/sidebar.js') }}"></script>
    <script src="{{ asset('vendor/jquery-confirm/jquery-confirm.min.js') }}"></script>

    <script>
        const appLocale = `<?= app()->getLocale() ?>`;
        const appLocaleData = {!! json_encode(config('languages')[app()->getLocale()]) !!};

        const months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        const handleWaitScreen = async (targetElement = `#kt_app_body`) => {
            let blockUI = new KTBlockUI(element = $(targetElement)[0], {
                message: `
                    <div class="blockui-message">
                        <span class="spinner-grow text-promary me-3"></span>
                        Loading...
                    </div>
                `,
            });

            if (blockUI.isBlocked() === false) {
                blockUI.block();
            }

            await new Promise((resolve) => setTimeout(resolve, 1000));

            return blockUI;
        }

        const currentTime = () => {
            var d = new Date();
            var p = d.getFullYear(),
                q = d.getMonth() + 1,
                r = d.getDate(),
                s = d.getHours(),
                t = d.getMinutes(),
                u = d.getSeconds();

            monthName = months[d.getMonth()];
            var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
            var dayName = days[d.getDay()];

            const result =
                `${dayName}, ${r} ${monthName} ${p} &nbsp;${String(s).padStart(2, '0')}:${String(t).padStart(2, '0')}:${String(u).padStart(2, '0')}`;
            $(`#current-time`).html(result);
        }
        setInterval(currentTime, 1000);

        const handleGetDeviceType = () => {
            const ua = navigator.userAgent;
            let deviceType = "Unknown Device";

            switch (true) {
                // Android devices
                case /android/i.test(ua):
                    deviceType = "Android Phone/Tablet";
                    break;

                    // Apple devices
                case /iPad|Tablet/i.test(ua):
                    deviceType = "iPad";
                    break;
                case /iPhone/i.test(ua):
                    deviceType = "iPhone";
                    break;
                case /iPod/i.test(ua):
                    deviceType = "iPod";
                    break;
                case /Macintosh/i.test(ua) && 'ontouchend' in document:
                    deviceType = "iPad"; // for iPadOS which reports as Macintosh
                    break;
                case /Macintosh/i.test(ua):
                    deviceType = "Mac Laptop/Desktop";
                    break;

                    // Windows devices
                case /Windows Phone/i.test(ua):
                    deviceType = "Windows Phone";
                    break;
                case /Windows NT 10.0/i.test(ua):
                    deviceType = "Windows 10 Laptop/Desktop";
                    break;
                case /Windows NT 6.3/i.test(ua):
                    deviceType = "Windows 8.1 Laptop/Desktop";
                    break;
                case /Windows NT 6.2/i.test(ua):
                    deviceType = "Windows 8 Laptop/Desktop";
                    break;
                case /Windows NT 6.1/i.test(ua):
                    deviceType = "Windows 7 Laptop/Desktop";
                    break;
                case /Windows NT 6.0/i.test(ua):
                    deviceType = "Windows Vista Laptop/Desktop";
                    break;
                case /Windows NT 5.1|Windows XP/i.test(ua):
                    deviceType = "Windows XP Laptop/Desktop";
                    break;

                    // Linux devices
                case /Linux/i.test(ua) && /Mobile/i.test(ua):
                    deviceType = "Linux Mobile";
                    break;
                case /Linux/i.test(ua):
                    deviceType = "Linux Laptop/Desktop";
                    break;

                    // Chrome OS
                case /CrOS/i.test(ua):
                    deviceType = "Chrome OS Device";
                    break;

                    // BlackBerry
                case /BB10/i.test(ua):
                    deviceType = "BlackBerry 10 Device";
                    break;
                case /BlackBerry/i.test(ua) || /BB/i.test(ua):
                    deviceType = "BlackBerry Device";
                    break;

                    // Other mobile devices
                case /Mobile/i.test(ua):
                    deviceType = "Mobile Device";
                    break;

                    // Other tablets
                case /Tablet/i.test(ua):
                    deviceType = "Tablet Device";
                    break;

                    // Default case
                default:
                    deviceType = "Unknown Device";
            }

            return deviceType;
        }

        const handleGetBrowserName = () => {
            const ua = navigator.userAgent;
            let browserName = "Unknown Browser";

            switch (true) {
                // Chrome
                case /Chrome\/\d+/i.test(ua) && !/Edg\/\d+/i.test(ua) && !/OPR\/\d+/i.test(ua):
                    browserName = "Google Chrome";
                    break;

                    // Firefox
                case /Firefox\/\d+/i.test(ua):
                    browserName = "Mozilla Firefox";
                    break;

                    // Safari
                case /Safari\/\d+/i.test(ua) && !/Chrome\/\d+/i.test(ua) && !/Chromium\/\d+/i.test(ua):
                    browserName = "Apple Safari";
                    break;

                    // Edge (Chromium-based)
                case /Edg\/\d+/i.test(ua):
                    browserName = "Microsoft Edge (Chromium-based)";
                    break;

                    // Edge (Legacy)
                case /Edge\/\d+/i.test(ua):
                    browserName = "Microsoft Edge (Legacy)";
                    break;

                    // Opera
                case /OPR\/\d+/i.test(ua):
                    browserName = "Opera";
                    break;

                    // Internet Explorer
                case /MSIE\s\d+/i.test(ua) || /Trident\/\d+/i.test(ua):
                    browserName = "Internet Explorer";
                    break;

                    // Other browsers
                default:
                    browserName = "Unknown Browser";
            }

            return browserName;
        }

        $(document).on('click', `#button_logout`, function() {
            $.confirm({
                theme: KTThemeMode.getMode(),
                title: 'Confirm!',
                content: `Are you sure to logout?`,
                type: 'orange',
                autoClose: 'close|5000',
                buttons: {
                    close: {
                        text: 'Close',
                        btnClass: 'btn btn-sm btn-secondary',
                        keys: ['esc'],
                    },
                    confirm: {
                        text: 'Yes, Logout',
                        btnClass: 'btn btn-sm btn-danger',
                        keys: ['enter'],
                        action: function() {
                            $(`#form_logout`).submit();
                        }
                    },
                }
            });
        });

        $(document).on('click', `[button-image-open]`, async function() {
            const thisElement = $(this);
            const source = $(this).attr('data-source') ?? '';

            $('#modal_image_img').attr('src', `{{ asset('themes/main/media/misc/spinner.gif') }}`);
            $('#modal_image').modal('show');

            await new Promise((resolve) => setTimeout(resolve, 1000));

            $('#modal_image_img').attr('src', source);
            $('#modal_image_img').attr('data-src', source);
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
