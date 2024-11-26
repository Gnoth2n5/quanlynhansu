@extends('layouts.defaultLayout')

@section('title', 'Chỉnh sửa ca làm việc')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Sửa Ca Làm Việc</h2>
                    <form action="{{$_ENV['APP_URL']}}/admin/update-shift/{{$shift->id}}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{$shift->id}}">

                        <div class="mb-3">
                            <label for="shiftName" class="form-label">Tên ca</label>
                            <input type="text" class="form-control" value="{{$shift->shift_name}}" id="shiftName" name="shiftName" placeholder="Nhập tên ca" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Giờ bắt đầu</label>
                            <input type="time" class="form-control" value="{{$shift->start_time}}" id="startTime" name="startTime" required>
                        </div>

                        <div class="mb-3">
                            <label for="endTime" class="form-label">Giờ kết thúc</label>
                            <input type="time" class="form-control" value="{{$shift->end_time}}" id="endTime" name="endTime" required>
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                        <a href="{{$_ENV['APP_URL']}}/admin/shift-management" class="btn btn-info">Quay lại</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
