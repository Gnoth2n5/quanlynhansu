@extends('layouts.defaultLayout')

@section('title', 'Thông tin cá nhân')

@section('content')

    <div class="row mt-3">
        <div class="col-lg-4">
            <div class="card profile-card-2">
                <div class="card-body pt-3">
                    <div class="row align-items-center">
                        <!-- Avatar section -->
                        <div class="col-auto">
                            <img src="/assets/images/faces/face1.jpg" alt="User Avatar" class="profile-avatar rounded-circle"
                                style="width: 80px; height: 80px;">
                        </div>
                        <!-- Name and Role section -->
                        <div class="col">
                            <h5 class="card-title mb-1">{{ $_SESSION['user']->full_name }}</h5>
                            <p class="card-text mb-1">
                                Chức vụ: @if ($_SESSION['role'] == 'admin')
                                    Quản trị viên
                                @elseif($_SESSION['role'] == 'manager')
                                    Trưởng phòng
                                @else
                                    Nhân viên
                                @endif
                            </p>
                            <p class="card-text">Thuộc: Phòng ban P101</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">UID</label>
                            <div class="col-lg-9">
                                <input class="form-control" disabled type="text" value="{{ $_SESSION['user']->UID }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Họ và Tên</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="{{ $_SESSION['user']->full_name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Email</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="email" value="{{ $_SESSION['user']->email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Avatar</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="file">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Address</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="{{ $_SESSION['user']['address'] ?? '' }}"
                                    placeholder="Địa chỉ...">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Username</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="{{ $_SESSION['user']->username }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Mật khẩu hiện tại</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Mật khẩu mới</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="password" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                                <input type="button" class="btn btn-primary" value="Lưu thay đổi">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
