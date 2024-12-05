@extends('layouts.defaultLayout')

@section('title', 'Quản lý Người dùng')

@php
    $i = 1;
@endphp

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <h3>Quản lý Người dùng</h3>
                    <a href="#" class="btn btn-primary btn-sm">Thêm mới</a>
                </div>

                <div class="table-responsive mb-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Họ tên</th>
                                <th>Phòng ban</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($data) == 0)
                                <tr>
                                    <td colspan="7" class="text-center">Không có dữ liệu</td>
                                </tr>
                            @endif  

                            @foreach ($data as $user)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->offices[0]->name ?? 'Chưa có phòng ban' }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($user->role->name == 'admin') badge-danger
                                            @elseif($user->role->name == 'user')
                                                badge-primary
                                            @elseif($user->role->name == 'manage')
                                                badge-warning
                                            @else
                                                badge-secondary @endif
                                            text-uppercase">
                                            {{ $user->role->name ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($user->status == 'active') badge-success
                                            @elseif($user->status == 'inactive')
                                                badge-danger
                                            @else
                                                badge-secondary @endif
                                            text-uppercase">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ $_ENV['APP_URL'] }}/admin/user-detail/{{ $user->UID }}-{{ $user->id }}"
                                            class="btn btn-info btn-sm">Xem</a>
                                        @if ($user->status == 'active')
                                            <a href="{{ $_ENV['APP_URL'] }}/admin/block-user/{{ $user->UID }}-{{ $user->id }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="SweetAlert(event, 'Bạn có chắc muốn khoá người dùng này không?', 'warning', {element: this, confirmBtn: true, cancelBtn: true})">Khoá</a>
                                        @else
                                            <a href="{{ $_ENV['APP_URL'] }}/admin/unlock-user/{{ $user->UID }}-{{ $user->id }}"
                                                class="btn btn-success btn-sm"
                                                onclick="SweetAlert(event, 'Bạn có chắc muốn mở khoá người dùng này không?', 'warning', {element: this, confirmBtn: true, cancelBtn: true})">Mở
                                                khoá</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @component('components.pagination.pagination', [
                    'currentPage' => $currentPage,
                    'totalPages' => $totalPages,
                ])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
