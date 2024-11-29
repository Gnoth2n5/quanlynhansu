@extends('layouts.defaultLayout')

@section('title', 'Sửa Bảng lương')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-3">
                    <h2 class="text-center">Sửa Bảng lương</h2>
                    <form id="createOfficeForm" action="{{ $_ENV['APP_URL'] }}/admin/update-salary" method="POST"
                        class="mt-4">

                        <input type="hidden" name="id" value="{{$salary->id}}">


                        <div class="mb-3 select">
                            <label for="nameUser" class="form-label">Tên Nhân viên</label>
                            <input type="text" class="form-control" value="{{$salary->users->full_name}}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="base" class="form-label">Lương cơ bản</label>
                            <input type="number" step="0.01" max="99999999.99" min="1" class="form-control" id="base" name="base"
                                placeholder="Nhập lương cơ bản" value="{{$salary->base_salary}}">
                        </div>

                        <div class="mb-3">
                            <label for="deductions" class="form-label">Khấu trừ</label>
                            <input type="number" step="0.01" max="99999999.99" min="0" class="form-control" id="deductions" name="deductions"
                                placeholder="Nhập khấu trừ" value="{{$salary->total_deductions}}">
                        </div>

                        <div class="mb-3">
                            <label for="bonus" class="form-label">Thưởng thêm</label>
                            <input type="number" step="0.01" max="99999999.99" min="0" class="form-control" id="bonus" name="bonus"
                                placeholder="Nhập thưởng" value="{{$salary->total_bonus}}">
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật bảng lương</button>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/salary-management" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection