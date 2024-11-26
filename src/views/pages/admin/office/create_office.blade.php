@extends('layouts.defaultLayout')

@section('title', 'Tạo phòng ban')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Tạo Phòng Mới</h2>
                    <form action="{{$_ENV['APP_URL']}}/admin/store-office" method="POST" class="mt-4">
                        
                        <div class="mb-3">
                            <label for="roomName" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control" id="roomName" name="roomName" placeholder="Nhập tên phòng" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="location" class="form-label">Vị trí</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Nhập vị trí" required>
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Tạo phòng</button>
                        <a href="{{$_ENV['APP_URL']}}/admin/office-management" class="btn btn-secondary">Quay lại</a>
                    </form>
                
            </div>
        </div>
    </div>
@endsection
