@extends('layouts.defaultLayout')

@section('title', 'Tạo đơn')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-2">
                    <h2 class="text-center">
                        Thông tin Đơn xin nghỉ
                    </h2>
                    <form class="mt-4">

                        <input type="hidden" name="id" value="{{ $leave_request->id }}" readonly>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" id="myDate" min="" class="form-control" id="start_date"
                                name="start_date" value="{{ $leave_request->start_date }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" id="myDate" min="" class="form-control" id="end_date"
                                name="end_date" value="{{ $leave_request->end_date }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="reason">Lý do xin nghỉ</label>
                            <textarea class="form-control" name="reason" id="reason" cols="30" rows="10"
                                readonly>
                                {{ $leave_request->reason }}
                            </textarea>
                        </div>

                        <a href="{{ $_ENV['APP_URL'] }}/admin/leave-request/approved/{{ $leave_request->id }}"
                            class="btn btn-success">Chấp nhận</a>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/leave-request/rejected/{{ $leave_request->id }}"
                            class="btn btn-danger">Từ chối</a>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/leave-management" class="btn btn-secondary">Quay lại</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
