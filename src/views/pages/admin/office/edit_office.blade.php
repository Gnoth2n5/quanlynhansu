@extends('layouts.defaultLayout')

@section('title', 'Chỉnh sửa phòng ban')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Sửa Phòng</h2>
                    <form action="" method="POST" class="mt-4">
                        <input type="hidden" name="id" value="{{$office->id}}">
                        <div class="mb-3">
                            <label for="roomName" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control" value="{{$office->name}}" id="roomName" name="roomName" placeholder="Nhập tên phòng" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="location" class="form-label">Vị trí</label>
                            <input type="text" class="form-control" value="{{$office->location}}" id="location" name="location" placeholder="Nhập vị trí" required>
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                        <a href="{{$_ENV['APP_URL']}}/admin/office-management" class="btn btn-info">Quay lại</a>
                    </form>
                

            </div>
        </div>
    </div>
@endsection
