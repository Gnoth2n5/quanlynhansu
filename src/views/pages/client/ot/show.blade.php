@extends('layouts.defaultLayout')

@section('title', 'Tạo đơn')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-2">
                    <h2 class="text-center">Sửa Đơn xin OT</h2>
                    <form action="{{ $_ENV['APP_URL'] }}/user/ot-request/update" method="POST" class="mt-4">

                        <input type="hidden" name="id" value="{{ $request->id }}">

                        <p class="card-title text-danger">
                            Chú ý:
                            Bạn chỉ có thể sửa hoặc xoá đơn xin OT trong vòng 30 phút kể từ lúc tạo.
                            Thời gian OT tối đa là 4 giờ.
                        </p>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Thời gian OT mong muốn</label>
                            <input type="number" min="1" max="4" class="form-control" id="ot_time"
                                name="ot_time" value="{{ $request->requested_hours }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Sửa đơn</button>
                        <a href="{{ $_ENV['APP_URL'] }}/user/ot-request" class="btn btn-secondary">Quay lại</a>
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
