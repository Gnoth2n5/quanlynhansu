@extends('layouts.defaultLayout')

@section('title', 'Bảng Đơn từ')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <h3>Đơn xin nghỉ</h3>
                    <a href="{{ $_ENV['APP_URL'] }}/user/leave-request/create" class="btn btn-primary btn-sm">Tạo mới</a>
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($data) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif

                        @foreach ($data as $request)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $request->start_date }}</td>
                                <td>{{ $request->end_date }}</td>
                                <td>
                                    @if ($request->status == 'pending')
                                        <label class="badge badge-warning">Chưa xử lý</label>
                                    @elseif ($request->status == 'approved')
                                        <label class="badge badge-success">Đã chấp nhận</label>
                                    @elseif ($request->status == 'rejected')
                                        <label class="badge badge-danger">Đã từ chối</label>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{$_ENV['APP_URL']}}/user/leave-request/show/{{$request->id}}" class="btn btn-info btn-sm">Xem</a>

                                    @if ($request->status == 'pending' && $request->created_at >= now()->subMinutes(30))
                                        <a href="{{ $_ENV['APP_URL'] }}/user/leave-request/show/{{ $request->id }}"
                                            class="btn btn-primary btn-sm">Sửa</a>
                                        <a href="{{ $_ENV['APP_URL'] }}/user/leave-request/delete/{{ $request->id }}"
                                            class="btn btn-danger btn-sm"
                                            onclick="SweetAlert(event, 'Bạn có chắc muốn xoá?', 'warning', {element: this, confirmBtn: true, cancelBtn: true})">Xóa</a>
                                    @endif

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
