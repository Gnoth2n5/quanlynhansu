@extends('layouts.defaultLayout')

@section('title', 'Quản lý thông báo')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <h3>Quản lý Thông báo</h3>
                    <a href="{{$_ENV['APP_URL']}}/admin/create-notify" class="btn btn-primary btn-sm">Tạo thông báo</a>
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề</th>
                            <th>Thời gian tạo</th>
                            <th>Đến</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($data) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif
                        @foreach ($data as $notify)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $notify->title }}</td>
                                <td>{{ $notify->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    {{ $notify->offices_count }} phòng ban, {{ $notify->users_count }} người
                                </td>
                                <td>
                                    <a href="{{$_ENV['APP_URL']}}/admin/edit-notify/{{$notify->id}}"
                                        class="btn btn-primary btn-sm">Xem & Sửa</a>
                                    <a href="{{$_ENV['APP_URL']}}/admin/delete-notify/{{$notify->id}}"
                                        class="btn btn-danger btn-sm"
                                        onclick="SweetAlert(event, 'Bạn có chắc muốn xoá?', 'error', {element: this, confirmBtn: true, cancelBtn: true})">Xóa</a>
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
