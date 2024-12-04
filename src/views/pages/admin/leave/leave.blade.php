@extends('layouts.defaultLayout')

@section('title', 'Quản lý Đơn từ')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Quản lý đơn từ</h3>
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Người gửi</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $request)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $request->users->full_name }}</td>
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
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/leave-show/{{ $request->id }}"
                                        class="btn btn-info btn-sm">Xem</a>

                                    @if($request->status == 'pending')

                                    <a href="{{ $_ENV['APP_URL'] }}/admin/leave-request/approved/{{ $request->id }}"
                                        class="btn btn-success btn-sm">Chấp nhận</a>
                                    <a href="{{ $_ENV['APP_URL'] }}/admin/leave-request/rejected/{{ $request->id }}"
                                        class="btn btn-danger btn-sm">Từ chối</a>

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
