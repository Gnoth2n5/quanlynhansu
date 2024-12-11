<?php
$sidebarItems = [
    [
        'label' => 'Dashboard',
        'icon' => 'icon-grid menu-icon',
        'url' => '/user/dashboard',
        'subMenu' => [],
        'roles' => ['user', 'manager'], // Hiển thị cho cả user và manager
    ],
    [
        'label' => 'Bảng chấm công',
        'icon' => 'icon-layout menu-icon',
        'url' => '/user/attendance',
        'subMenu' => [],
        'roles' => ['user', 'manager'],
    ],
    [
        'label' => 'Đơn từ',
        'icon' => 'fa-regular fa-paper-plane menu-icon',
        'url' => '#request',
        'subMenu' => [['label' => 'Đơn xin nghỉ', 'url' => '/user/leave-request'], ['label' => 'Đơn xin OT', 'url' => '/user/ot-request']],
        'roles' => ['user', 'manager'],
    ],
    // [
    //     'label' => 'Quản lý nhân viên',
    //     'icon' => 'fa-solid fa-users menu-icon',
    //     'url' => '/manager/department',
    //     'subMenu' => [],
    //     'roles' => ['manager'], // Chỉ hiển thị cho manager
    // ],
    // [
    //     'label' => 'Quản lý đơn xin nghỉ',
    //     'icon' => 'fa-solid fa-envelopes-bulk menu-icon',
    //     'url' => '/manager/department',
    //     'subMenu' => [],
    //     'roles' => ['manager'], // Chỉ hiển thị cho manager
    // ],
    [
        'label' => 'Thông báo',
        'icon' => 'fa-regular fa-bell menu-icon',
        'url' => '/user/notification',
        'subMenu' => [],
        'roles' => ['user', 'manager'],
    ],
    [
        'label' => 'Thông tin cá nhân',
        'icon' => 'fa-regular fa-user menu-icon',
        'url' => '/user/profile',
        'subMenu' => [],
        'roles' => ['user', 'manager'],
    ],
];

?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center mb-4 profile-section mt-4">
        <!-- Avatar -->
        <img src="{{ isset($_SESSION['user']['avatar']) ? '/uploads/avatar/' . $_SESSION['user']['avatar'] : '/assets/images/faces/face1.jpg' }}"
            class="img-fluid border profile-avatar" alt="User Avatar">
        <!-- Tên người dùng -->
        <h5 class="mt-2 profile-name">{{ $_SESSION['user']['full_name'] }}</h5>
        <!-- Vai trò -->
        <p class="text-muted">{{ $_SESSION['role'] == 'user' ? 'Nhân viên' : 'Trưởng phòng' }}</p>
    </div>
    <ul class="nav">
        @foreach ($sidebarItems as $item)
            @if (in_array($_SESSION['role'], $item['roles']))
                <!-- Kiểm tra role -->
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
            @endif
        @endforeach
    </ul>
</nav>
