<?php
$sidebarItems = [
    [
        'label' => 'Dashboard',
        'icon' => 'icon-grid menu-icon',
        'url' => '/admin/dashboard',
        'subMenu' => [],
    ],
    [
        'label' => 'Quản lý Phòng ban',
        'icon' => 'icon-layout menu-icon',
        'url' => '/admin/office-management',
        'subMenu' => [],
    ],
    [
        'label' => 'Quản lý Người dùng',
        'icon' => 'fa-solid fa-users menu-icon',
        'url' => '/admin/user-management',
        'subMenu' => [],
    ],
    [
        'label' => 'Quản lý Đơn từ',
        'icon' => 'fa-regular fa-envelope menu-icon',
        'url' => '#request',
        'subMenu' => [['label' => 'Đơn xin nghỉ phép', 'url' => '/admin/leave-management'], ['label' => 'Đơn xin OT', 'url' => '/admin/ot-management']],
    ],
    [
        'label' => 'Quản lý Ca làm việc',
        'icon' => 'fa-regular fa-clock menu-icon',
        'url' => '#shift',
        'subMenu' => [['label' => 'Bảng ca làm việc', 'url' => '/admin/shift-management'], ['label' => 'Phân ca', 'url' => '/admin/user-shift']],
    ],
    [
        'label' => 'Quản lý Lương',
        'icon' => 'fa-solid fa-coins menu-icon',
        'url' => '/admin/salary-management',
        'subMenu' => [],
    ],
    [
        'label' => 'Quản lý thông báo',
        'icon' => 'fa-regular fa-bell menu-icon',
        'url' => '/admin/notify-management',
        'subMenu' => [],
    ],
    [
        'label' => 'Thống kê',
        'icon' => 'fa-solid fa-chart-pie menu-icon',
        'url' => '/admin/statistic',
        'subMenu' => [],
    ],
    [
        'label' => 'Cài đặt',
        'icon' => 'fa-solid fa-gears menu-icon',
        'url' => '#setting',
        'subMenu' => [['label' => 'Hệ thống', 'url' => '/admin/system-setting']],
    ],
    // [
    //     'label' => 'Error pages',
    //     'icon' => 'icon-ban menu-icon',
    //     'url' => '#error',
    //     'subMenu' => [['label' => '404', 'url' => 'pages/samples/error-404.html'], ['label' => '500', 'url' => 'pages/samples/error-500.html']],
    // ],
    // [
    //     'label' => 'Documentation',
    //     'icon' => 'icon-paper menu-icon',
    //     'url' => 'pages/documentation/documentation.html',
    //     'subMenu' => [],
    // ],
];

?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center mb-4 profile-section mt-4">
        <!-- Avatar -->
        <img src="{{ isset($_SESSION['user']->avatar) ? '/uploads/avatar/' . $_SESSION['user']->avatar : '/assets/images/faces/face1.jpg' }}"
            class="img-fluid border profile-avatar" alt="User Avatar">
        <!-- Tên người dùng -->
        <h5 class="mt-2 profile-name">{{ $_SESSION['user']['full_name'] }}</h5>
    </div>
    <ul class="nav">
        @foreach ($sidebarItems as $item)
            <li class="nav-item">
                <a class="nav-link" href="{{ $item['url'] }}"
                    data-toggle="{{ count($item['subMenu']) > 0 ? 'collapse' : '' }}" aria-expanded="false"
                    aria-controls="{{ str_replace('#', '', $item['url']) }}">
                    <i class="{{ $item['icon'] }}"></i>
                    <span class="menu-title">{{ $item['label'] }}</span>
                    @if (count($item['subMenu']) > 0)
                        <i class="menu-arrow"></i>
                    @endif
                </a>
                @if (count($item['subMenu']) > 0)
                    <div class="collapse" id="{{ str_replace('#', '', $item['url']) }}">
                        <ul class="nav flex-column sub-menu">
                            @foreach ($item['subMenu'] as $subItem)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $subItem['url'] }}">{{ $subItem['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
