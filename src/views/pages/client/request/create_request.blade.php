@extends('layouts.defaultLayout')

@section('title', 'Tạo đơn')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-2">
                    <h2 class="text-center">Tạo Đơn xin nghỉ</h2>
                    <form action="{{ $_ENV['APP_URL'] }}/user/leave-request/store" method="POST"
                        class="mt-4">

                        <p class="card-description text-danger">
                            Chú ý: Bạn chỉ có thể sửa hoặc xoá đơn xin nghỉ trong vòng 30 phút kể từ lúc tạo.
                        </p>
                         
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" id="myDate" min="" class="form-control" id="start_date" name="start_date"
                                placeholder="Nhập tên phòng">
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" id="myDate" min="" class="form-control" id="end_date" name="end_date"
                                placeholder="Nhập vị trí">
                        </div>

                        <div class="mb-3">
                            <label for="reason">Lý do xin nghỉ</label>
                            <textarea class="form-control" name="reason" id="reason" cols="30" rows="10"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Tạo đơn</button>
                        <a href="{{ $_ENV['APP_URL'] }}/user/leave-request" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>    
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('myDate').min = new Date().toISOString().split('T')[0];
    </script>
@endsection