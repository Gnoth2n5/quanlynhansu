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
                                <th>ID</th>
                                <th>Username</th>
                                <th>Họ tên</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $user)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->full_name }}</td>
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
                                        <a href="" class="btn btn-info btn-sm">Xem</a>
                                        <a href="" class="btn btn-primary btn-sm">Sửa</a>
                                        <a href="#" class="btn btn-danger btn-sm" onclick="check(event)">Xoá</a>
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

@section('script')
    <script>
        function check(event) {
            event.preventDefault();
            SweetAlert('Bạn có chắc chắn muốn xóa người dùng này?', 'warning', {
                confirmBtn: true,
                cancelBtn: true,
            });
        }
    </script>
@endsection
