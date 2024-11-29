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
                            <img src="{{ isset($user->avatar) ? '/uploads/avatar/' . $user->avatar : '/assets/images/faces/face1.jpg' }}" alt="User Avatar" class="profile-avatar rounded-circle"
                                style="width: 80px; height: 80px;">
                        </div>
                        <!-- Name and Role section -->
                        <div class="col">
                            <h5 class="card-title mb-1">{{ $user->full_name }}</h5>
                            <p class="card-text mb-1">
                                Chức vụ: @if ($_SESSION['role'] == 'admin')
                                    Quản trị viên
                                @elseif($_SESSION['role'] == 'manager')
                                    Trưởng phòng
                                @else
                                    Nhân viên
                                @endif
                            </p>
                            <p class="card-text">Thuộc: 
                                @if ($user->offices->isNotEmpty())
                                    {{ $user->offices->first()->name }}
                                @else
                                    Chưa có phòng ban
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{$_ENV['APP_URL']}}/user/update-profile" enctype="multipart/form-data" method="POST">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">UID</label>
                            <div class="col-lg-9">
                                <input class="form-control" disabled name="UID" type="text" value="{{ $user->UID }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Username</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="username" type="text" value="{{ $user->username }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Họ và Tên</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="fullname" type="text" value="{{ $user->full_name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Email</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="email" type="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Avatar</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="avatar" type="file">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Địa chỉ</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="address" type="text" value="{{ $user['address'] ?? '' }}"
                                    placeholder="Địa chỉ...">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Số ĐT</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="phone" type="text" value="{{ $user['phone'] ?? '' }}"
                                    placeholder="Số điện thoại...">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Năm sinh</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="birthday" type="date" value="{{ $user['birthday'] ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Giới tính</label>
                            <div class="col-lg-9">
                                <select name="gender" id="" class="form-control">
                                    <option value="male" {{$user->gender == 'male' ? 'selected' : ''}}>Nam</option>
                                    <option value="female" {{$user->gender == 'female' ? 'selected' : ''}}>Nữ</option>
                                    <option value="other" {{$user->gender == 'other' ? 'selected' : ''}}>Khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-9">
                                <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                                <input type="submit" class="btn btn-primary" value="Lưu thay đổi">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
