<?php
$menu = [
    [
        'name' => __('Preview'),
        'icon' => '
            <i class="ki-solid ki-user fs-4 me-2"></i>
        ',
        'route' => 'profile.index',
        'conditional' => [],
    ],
    [
        'name' => __('Edit'),
        'icon' => '
            <i class="ki-solid ki-setting fs-4 me-2"></i>
        ',
        'route' => 'profile.edit',
        'conditional' => [
            auth()
                ->user()
                ->hasAnyPermission(['auth.edit']),
        ],
    ],
    [
        'name' => __('Security'),
        'icon' => '
            <i class="ki-solid ki-lock fs-4 me-2"></i>
        ',
        'route' => 'profile.edit.security',
        'conditional' => [
            auth()
                ->user()
                ->hasAnyPermission(['auth.edit-email', 'auth.edit-password']),
        ],
    ],
];
?>

<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    @foreach ($menu as $menu)
        @if ($menu['conditional'] === [] || array_search(true, $menu['conditional']) !== false)
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 py-5 ps-1 pe-3 {{ request()->routeIs($menu['route']) ? 'active' : '' }}"
                    href="{{ request()->routeIs($menu['route']) ? 'javascript:;' : route($menu['route']) }}">
                    {!! $menu['icon'] !!}
                    {{ $menu['name'] }}
                </a>
            </li>
        @endif
    @endforeach
</ul>
