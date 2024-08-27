<div class="app-navbar flex-shrink-0 ms-1 ms-md-4">
    <div class="d-none d-sm-flex flex-column justify-content-center flex-wrap align-items-end">
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 mb-1 ">
            <li class="breadcrumb-item text-gray-800">Tim IT {{ config('app.short_name') }},</li>
        </ul>
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-6 my-0">
            {{ auth()->user()->full_name }}
        </h1>
    </div>

    {{--
    <!--begin::Activities-->
    <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Drawer toggle-->
        <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
            id="kt_activities_toggle">
            <i class="ki-outline ki-messages fs-2"></i>
        </div>
        <!--end::Drawer toggle-->
    </div>
    <!--end::Activities-->
    --}}

    <!--begin::Theme mode-->
    <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu toggle-->
        <a href="#"
            class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
            data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <i class="ki-outline ki-night-day theme-light-show fs-1"></i>
            <i class="ki-outline ki-moon theme-dark-show fs-1"></i>
        </a>
        <!--begin::Menu toggle-->

        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
            data-kt-menu="true" data-kt-element="theme-mode-menu">
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="ki-outline ki-night-day fs-2"></i>
                    </span>
                    <span class="menu-title">{{ __('Light') }}</span>
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="ki-outline ki-moon fs-2"></i>
                    </span>
                    <span class="menu-title">{{ __('Dark') }}</span>
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="ki-outline ki-screen fs-2"></i>
                    </span>
                    <span class="menu-title">{{ __('System') }}</span>
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Theme mode-->

    <!--begin::User menu-->
    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <img src="{{ auth()->user()->full_image_url }}" class="rounded-3" alt="user" />
        </div>
        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <img src="{{ auth()->user()->full_image_url }}" alt="" />
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">
                            {{ auth()->user()->full_name }}
                        </div>
                        <span class="fw-semibold text-muted text-hover-primary fs-7 text-truncate"
                            style="max-width: 125pt;">
                            {{ auth()->user()->username }}
                        </span>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{ route('profile.index') }}" class="menu-link px-5">{{ __('My Profile') }}</a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            {{--
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">
                        {{ __('Language') }}
                        <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                            {{ config('languages')[app()->getLocale()]['name'] }}
                            <img class="w-15px h-15px rounded-1 ms-2"
                                src="{{ asset(config('languages')[app()->getLocale()]['flag_image_url']) }}"
                                alt="" />
                        </span>
                    </span>
                </a>
                <!--begin::Menu sub-->
                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                    @foreach (config('languages') as $item)
                        <div class="menu-item px-3">
                            <a href="{{ route('language.switch', $item['id']) }}"
                                class="menu-link d-flex px-5 {{ $item['id'] === app()->getLocale() ? 'active' : '' }}">
                                <span class="symbol symbol-20px me-4">
                                    <img class="rounded-1" src="{{ asset($item['flag_image_url']) }}" alt="" />
                                </span>
                                {{ $item['name'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
                <!--end::Menu sub-->
            </div>
            --}}
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <form id="form_logout" method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a id="button_logout" class="menu-link px-5" href="javascript:;">
                        {{ __('Sign Out') }}
                    </a>
                </form>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
</div>
