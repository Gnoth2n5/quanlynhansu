@extends('layouts.defaultLayout')

@section('title', 'Bảng OT')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <h3>Đơn xin OT</h3>
                    {{-- <a href="{{ $_ENV['APP_URL'] }}/user/leave-request/create" class="btn btn-primary btn-sm">Tạo mới</a> --}}
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ca</th>
                            <th>Thời gian OT đề xuất</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data) == 0)
                            <tr>
                                <td colspan="6" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif

                        @foreach ($data as $request)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $request->shift->shift_name ?? '' }}</td>
                                <td>{{ $request->requested_hours }} giờ</td>
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
                                    @if ($request->status == 'pending' && $request->created_at >= now()->subMinutes(30))
                                        <a href="{{ $_ENV['APP_URL'] }}/user/ot-request/show/{{ $request->id }}"
                                            class="btn btn-primary btn-sm">Sửa</a>
                                        <a href="{{ $_ENV['APP_URL'] }}/user/ot-request/delete/{{ $request->id }}"
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
