@extends('layouts.defaultLayout')

@section('title', 'Quản lý Lương')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Quản lý Lương</h3>
                    <a href="{{ $_ENV['APP_URL'] }}/admin/create-salary" class="btn btn-primary btn-sm">Tạo bảng lương
                        mới</a>
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Lương cơ bản</th>
                            <th>Nhận được</th>
                            <th>Ngày tính</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($data) == 0)
                            <tr>
                                <td colspan="7" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif
                        @foreach ($data as $salary)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $salary->users->full_name }}</td>
                                <td>{{ number_format($salary->base_salary, 0, ',', '.') }} VNĐ</td>
                                <td>{{ number_format($salary->net_salary, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $salary->updated_at }}</td>
                                <td>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/show/{{ $salary->id }}" class="btn btn-info btn-sm">
                                        Xem chi tiết
                                    </a>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/edit-salary/{{ $salary->id }}/{{ $salary->user_id }}"
                                        class="btn btn-primary btn-sm">Sửa</a>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/delete-salary/{{ $salary->id }}"
                                        class="btn btn-danger btn-sm"
                                        onclick="SweetAlert(event, 'Bạn có chắc muốn xoá?', 'warning', {element: this, confirmBtn: true, cancelBtn: true})">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @component('components.pagination.pagination', [
                    'currentPage' => $currentPage,
                    'totalPages' => $totalPages,
                ])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
