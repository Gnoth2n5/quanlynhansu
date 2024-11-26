@extends('layouts.defaultLayout')

@section('title', 'Quản lý thông báo')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <h3>Quản lý Thông báo</h3>
                    <a href="" class="btn btn-primary btn-sm">Tạo thông báo</a>
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên phòng</th>
                            <th>Vị trí</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $notify)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $notify->name }}</td>
                                <td>{{ $notify->location }}</td>
                                <td>
                                    <a href=""
                                        class="btn btn-primary btn-sm">Sửa</a>
                                    <a href=""
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
