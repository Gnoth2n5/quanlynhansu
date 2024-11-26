@extends('layouts.authLayout')

@section('title', 'Đăng kí')

@section('content')
    <h4>New here?</h4>
    <h6 class="font-weight-light">Đăng ký dễ dàng! Nhanh chóng sử dụng</h6>
    <form class="pt-3" action="<?= $_ENV['APP_URL'] ?>/register" method="POST">
        <div class="row">
            <!-- Cột thứ nhất -->
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="text" name="full_name" class="form-control form-control-lg" placeholder="Họ và tên">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email">
                </div>
            </div>
            <!-- Cột thứ hai -->
            <div class="col-md-6">
                <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control form-control-lg"
                        placeholder="Nhập lại mật khẩu">
                </div>
                <div class="form-group">
                    <input type="date" name="birthday" class="form-control form-control-lg"
                        placeholder="Ngày tháng năm sinh">
                </div>
            </div>
        </div>

        <!-- Trường giới tính -->
        <div class="form-group">
            <select name="gender" class="form-control form-control-lg text-primary">
                <option value="male">Giới tính: Nam</option>
                <option value="female">Giới tính: Nữ</option>
                <option value="other">Khác</option>
            </select>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input">
                    Tôi đồng ý mọi điều khoản và điều kiện
                </label>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Đăng
                ký</button>
        </div>

        <div class="text-center mt-4 font-weight-light">
            Bạn đã có tài khoản? <a href="<?= $_ENV['APP_URL'] ?>" class="text-primary">Đăng nhập</a>
        </div>
    </form>

@endsection
