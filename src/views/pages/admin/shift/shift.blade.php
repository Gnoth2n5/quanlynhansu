@extends('layouts.defaultLayout')

@section('title', 'Quản lý ca làm việc')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <h3>Quản lý Ca Làm Việc</h3>
                    <a href="{{ $_ENV['APP_URL'] }}/admin/create-shift" class="btn btn-primary btn-sm">Thêm Ca</a>
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên ca</th>
                            <th>Thời gian bắt đầu</th>
                            <th>Thời gian kết thúc</th>
                            <th>Overtime</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $shift)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $shift->shift_name }}</td>
                                <td>{{ $shift->start_time }}</td>
                                <td>{{ $shift->end_time }}</td>
                                <td>{{ $shift->is_overtime }}</td>
                                <td>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/edit-shift/{{ $shift->id }}"
                                        class="btn btn-primary btn-sm">Sửa</a>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/delete-shift/{{ $shift->id }}"
                                        class="btn btn-danger btn-sm"
                                        onclick="SweetAlert(event, 'Bạn có chắc muốn xoá?', 'error', {element: this, confirmBtn: true, cancelBtn: true}"
                                    >Xoá</a>
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
