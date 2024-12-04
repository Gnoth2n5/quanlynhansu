@extends('layouts.defaultLayout')

@section('title', 'Quản lý Lương')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Quản lý Lương</h3>
                    <a href="{{ $_ENV['APP_URL'] }}/admin/create-salary" class="btn btn-primary btn-sm">Tạo bảng lương mới</a>
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Lương cơ bản</th>
                            <th>Khấu trừ</th>
                            <th>Thưởng thêm</th>
                            <th>Nhận được</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $salary)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $salary->users->full_name }}</td>
                                <td>{{ $salary->base_salary }} VNĐ</td>
                                <td>{{ $salary->total_deductions }} VNĐ</td>
                                <td>{{ $salary->total_bonus }} VNĐ</td>
                                <td>{{ $salary->net_salary }} VNĐ</td>
                                <td>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/edit-salary/{{ $salary->id }}"
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
