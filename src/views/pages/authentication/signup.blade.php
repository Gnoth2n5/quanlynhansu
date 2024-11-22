@extends('layouts.authLayout')

@section('title', 'Đăng nhập')

@section('content')
    <h4>New here?</h4>
    <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
    <form class="pt-3" action="<?=$_ENV['APP_URL']?>/register" method="POST">
        <div class="form-group">
            <input type="text" name="username" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
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
