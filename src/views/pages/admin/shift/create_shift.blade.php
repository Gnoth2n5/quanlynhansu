@extends('layouts.defaultLayout')

@section('title', 'Tạo ca làm việc')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Tạo Ca Làm Việc Mới</h2>
                    <form action="{{ $_ENV['APP_URL'] }}/admin/store-shift" method="POST" class="mt-4">

                        <div class="mb-4">
                            <label for="shiftName" class="form-label fw-bold">Tên ca</label>
                            <input type="text" class="form-control form-control-lg" id="shiftName" name="shiftName"
                                placeholder="Nhập tên ca" required>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="startTime" class="form-label fw-bold">Giờ bắt đầu</label>
                                <input type="text" class="form-control form-control-lg timepicker" id="startTime"
                                    name="startTime" required>
                            </div>
                            <div class="col-md-6">
                                <label for="endTime" class="form-label fw-bold">Giờ kết thúc</label>
                                <input type="text" class="form-control form-control-lg timepicker" id="endTime"
                                    name="endTime" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Overtime</label>
                            <div>
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label" for="overtimeYes">
                                        Có
                                        <input class="form-check-input" type="radio" name="isOvertime" id="overtimeYes"
                                            value="1">
                                    </label>
                                </div>
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label" for="overtimeNo">
                                        Không
                                        <input class="form-check-input" type="radio" name="isOvertime" id="overtimeNo"
                                            value="0" checked>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Tạo ca</button>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/shift-management" class="btn btn-secondary">Quay lại</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
