@extends('layouts.defaultLayout')

@section('title', 'Quản lý phòng ban')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <a href="" class="btn btn-primary btn-sm">Thêm phòng</a>

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
                        @foreach ($data as $office)
                            <tr>
                                <td>{{ $office->id }}</td>
                                <td>{{ $office->name }}</td>
                                <td>{{ $office->location }}</td>
                                <td>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/edit-office/{{$office->id}}" class="btn btn-primary btn-sm">Sửa</a>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/delete-office/{{$office->id}}" class="btn btn-danger btn-sm"
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
