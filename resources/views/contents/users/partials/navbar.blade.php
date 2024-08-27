<?php
$menu = [
    [
        'name' => __('Edit'),
        'icon' => '
            <i class="ki-solid ki-user fs-4 me-2"></i>
        ',
        'route' => 'users.edit',
        'conditional' => [
            auth()
                ->user()
                ->hasAnyPermission(['user.edit']),
        ],
    ],
    [
        'name' => __('Security'),
        'icon' => '
            <i class="ki-solid ki-lock fs-4 me-2"></i>
        ',
        'route' => 'users.edit.security',
        'conditional' => [
            auth()
                ->user()
                ->hasAnyPermission(['user.edit-security']),
        ],
    ],
    [
        'name' => __('Roles'),
        'icon' => '
            <i class="ki-solid ki-security-user fs-4 me-2"></i>
        ',
        'route' => 'users.edit.role',
        'conditional' => [
            auth()
                ->user()
                ->hasAnyPermission(['user.edit-role']),
        ],
    ],
    [
        'name' => __('Settings'),
        'icon' => '
            <i class="ki-solid ki-setting-4 fs-4 me-2"></i>
        ',
        'route' => 'users.edit.setting',
        'conditional' => [
            auth()
                ->user()
                ->hasAnyPermission(['user.edit-setting']),
        ],
    ],
];
?>

<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-5 mb-sm-3">
    @foreach ($menu as $menu)
        @if ($menu['conditional'] === [] || array_search(true, $menu['conditional']) !== false)
            <li class="nav-item mb-4 mb-sm-5">
                <a class="nav-link text-active-primary ps-1 pe-3 {{ request()->routeIs($menu['route']) ? 'active' : '' }}"
                    href="{{ request()->routeIs($menu['route']) ? 'javascript:;' : route($menu['route'], $query->id) }}">
                    {!! $menu['icon'] !!}
                    {{ $menu['name'] }}
                </a>
            </li>
        @endif
    @endforeach
</ul>
