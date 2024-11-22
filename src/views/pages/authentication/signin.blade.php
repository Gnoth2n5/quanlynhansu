@extends('layouts.authLayout')

@section('title', 'Đăng nhập')

@section('content')
    <h4>Hello! let's get started</h4>
    <h6 class="font-weight-light">Đăng nhập để tiếp tục.</h6>
    <form class="pt-3" method="POST" action="<?= $_ENV['APP_URL'] ?>/login">
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-lg rounded" id="exampleInputEmail1"
                placeholder="Nhập email đăng nhập...">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control form-control-lg rounded" id="exampleInputPassword1"
                placeholder="Nhập mật khẩu...">
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">ĐĂNG
                NHẬP</button>
        </div>
        <div class="text-center mt-4 font-weight-light">
            Bạn chưa có tài khoản? <a href="<?=$_ENV['APP_URL']?>/signup" class="text-primary">Đăng ký</a>
        </div>
    </form>
@endsection
