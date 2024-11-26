@extends('layouts.defaultLayout')

@section('title', 'Thông tin người dùng')

@section('content')
    <div class="row mt-3">
        <!-- Profile Section -->
        <div class="col-lg-4">
            <div class="card profile-card-2">
                <div class="card-body pt-3">
                    <div class="row align-items-center">
                        <!-- Avatar -->
                        <div class="col-auto">
                            <img src="/assets/images/faces/face1.jpg" alt="User Avatar" class="profile-avatar rounded-circle"
                                style="width: 80px; height: 80px;">
                        </div>
                        <!-- Name and Role -->
                        <div class="col">
                            <h5 class="card-title mb-1">{{ $user->full_name }}</h5>
                            <p class="card-text mb-1">
                                Chức vụ:
                                @if ($_SESSION['role'] == 'admin')
                                    Quản trị viên
                                @elseif($_SESSION['role'] == 'manager')
                                    Trưởng phòng
                                @else
                                    Nhân viên
                                @endif
                            </p>
                            <p class="card-text">Thuộc: Phòng ban P101</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST">

                        <!-- UID -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">UID</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="UID" type="text" value="{{ $user->UID }}"
                                    disabled>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Họ và Tên</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="fullname" type="text" value="{{ $user->full_name }}">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Email</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="email" type="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <!-- Avatar -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Avatar</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="avatar" type="file">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Địa chỉ</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="address" type="text"
                                    value="{{ $user['address'] ?? '' }}" placeholder="Địa chỉ...">
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Username</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="username" type="text" value="{{ $user->username }}">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Trạng thái</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="status">
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Đang hoạt động
                                    </option>
                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Không hoạt
                                        động</option>
                                    <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Tạm khóa
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Vai trò</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="role">
                                    <option value="admin" {{ $_SESSION['role'] == 'admin' ? 'selected' : '' }}>Quản trị
                                        viên</option>
                                    <option value="manager" {{ $_SESSION['role'] == 'manager' ? 'selected' : '' }}>Trưởng
                                        phòng</option>
                                    <option value="employee" {{ $_SESSION['role'] == 'employee' ? 'selected' : '' }}>Nhân
                                        viên</option>
                                </select>
                            </div>
                        </div>

                        <!-- Work Shift -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Ca làm việc</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="work_shift">
                                    <option value="morning" {{ $user->work_shift == 'morning' ? 'selected' : '' }}>Sáng
                                    </option>
                                    <option value="afternoon" {{ $user->work_shift == 'afternoon' ? 'selected' : '' }}>
                                        Chiều</option>
                                    <option value="night" {{ $user->work_shift == 'night' ? 'selected' : '' }}>Tối
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                                <input type="button" class="btn btn-primary" value="Lưu thay đổi">
                                <a href="{{$_ENV['APP_URL']}}/admin/user-management" class="btn btn-info">Quay lại</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
