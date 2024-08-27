<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack flex-wrap flex-md-nowrap">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
            data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_toolbar_container'}"
            class="page-title d-flex flex-column justify-content-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                @if (isset($title))
                    {{ $title }}
                @else
                    {{ config('app.full_name') }}
                @endif
            </h1>
            <!--end::Title-->

            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                @foreach ($breadcrumbs as $item)
                    <!--begin::Item-->
                    @if ($item['url'] && $loop->last === false)
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ $item['url'] }}" class="text-muted text-hover-primary">{{ $item['name'] }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item text-muted">{{ $item['name'] }}</li>
                    @endif
                    <!--end::Item-->

                    @if ($loop->last === false)
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-8px h-2px"></span>
                        </li>
                        <!--end::Item-->
                    @endif
                @endforeach
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

        <!--begin::Action group-->
        <div class="d-flex align-items-center overflow-auto">
            <!--begin::Wrapper-->
            <!--begin::Online users-->
            <div class="symbol-group symbol-hover flex-shrink-0">
                @forelse ($onlineUsers as $item)
                    @if ($item)
                        <div class="symbol symbol-circle symbol-30px" data-bs-toggle="tooltip"
                            title="{{ $item->full_name }}">
                            <img alt="Pic" src="{{ $item->full_image_url }}" />
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
            <!--end::Online users-->
            <!--end::Wrapper-->
        </div>
        <!--end::Action group-->
    </div>
    <!--end::Toolbar container-->
</div>
