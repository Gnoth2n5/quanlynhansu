@extends('layouts.defaultLayout')

@section('title', 'Tạo ca làm việc')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Tạo Ca Làm Việc Mới</h2>
                    <form action="{{$_ENV['APP_URL']}}/admin/store-shift" method="POST" class="mt-4">
                        
                        <div class="mb-3">
                            <label for="shiftName" class="form-label">Tên ca</label>
                            <input type="text" class="form-control" id="shiftName" name="shiftName" placeholder="Nhập tên ca" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Giờ bắt đầu</label>
                            <input type="time" class="form-control" id="startTime" name="startTime" required>
                        </div>

                        <div class="mb-3">
                            <label for="endTime" class="form-label">Giờ kết thúc</label>
                            <input type="time" class="form-control" id="endTime" name="endTime" required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Thêm ghi chú (nếu có)"></textarea>
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Tạo ca</button>
                        <a href="{{$_ENV['APP_URL']}}/admin/shift-management" class="btn btn-secondary">Quay lại</a>
                    </form>
                
            </div>
        </div>
    </div>
@endsection
