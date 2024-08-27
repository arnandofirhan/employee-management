@if (auth()->user())
    <x-main-app-layout :isCenter="true">
        <x-slot name="title">@yield('title')</x-slot>

        <div class="d-flex flex-column text-center">
            <!--begin::Illustration-->
            <div class="mb-0">
                <img src="@yield('lightImage', asset('assets/images/errors/question.png'))" class="mw-100 mh-300px theme-light-show" alt="" />
                <img src="@yield('darkImage', asset('assets/images/errors/question-dark.png'))" class="mw-100 mh-300px theme-dark-show" alt="" />
            </div>
            <!--end::Illustration-->

            <!--begin::Title-->
            <h1 class="fw-bolder fs-1qx text-gray-700 mb-3">
                Oops! 😖 The requested page got errors
            </h1>
            <!--end::Title-->

            <!--begin::Text-->
            <div class="fw-semibold fs-4 text-gray-600 mb-15">@yield('message')</div>
            <!--end::Text-->

            <!--begin::Link-->
            <div class="mb-0">
                <a class="btn btn-sm btn-primary"
                    href="{{ url()->previous() === url()->full() ? url()->to('') : url()->previous() }}">
                    {{ __('Back to ' . (url()->previous() === url()->full() ? 'home' : 'previous page')) }}
                </a>
            </div>
            <!--end::Link-->
        </div>
    </x-main-app-layout>
@else
    <x-main-guest-layout>
        <x-slot name="title">@yield('title')</x-slot>

        <div class="d-flex flex-column text-center">
            <!--begin::Illustration-->
            <div class="mb-0">
                <img src="@yield('lightImage', asset('assets/images/errors/question.png'))" class="mw-100 mh-300px theme-light-show" alt="" />
                <img src="@yield('darkImage', asset('assets/images/errors/question-dark.png'))" class="mw-100 mh-300px theme-dark-show" alt="" />
            </div>
            <!--end::Illustration-->

            <!--begin::Title-->
            <h1 class="fw-bolder fs-1qx text-gray-700 mb-3">
                Oops! 😖 The requested page got errors
            </h1>
            <!--end::Title-->

            <!--begin::Text-->
            <div class="fw-semibold fs-4 text-gray-600 mb-15">@yield('message')</div>
            <!--end::Text-->

            <!--begin::Link-->
            <div class="mb-0">
                <a class="btn btn-sm btn-primary"
                    href="{{ url()->previous() === url()->full() ? url()->to('') : url()->previous() }}">
                    {{ __('Back to ' . (url()->previous() === url()->full() ? 'home' : 'previous page')) }}
                </a>
            </div>
            <!--end::Link-->
        </div>
    </x-main-guest-layout>
@endif
