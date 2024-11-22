@extends('layouts.authLayout')

@section('title', 'Sign In')

@section('content')
    <h4>Hello! let's get started</h4>
    <h6 class="font-weight-light">Đăng nhập để tiếp tục.</h6>
    <form class="pt-3">
        <div class="form-group">
            <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Nhập email đăng nhập...">
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Nhập mật khẩu...">
        </div>
        <div class="mt-3">
            <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">ĐĂNG NHẬP</a>
        </div>
        <div class="text-center mt-4 font-weight-light">
            Bạn chưa có tài khoản? <a href="" class="text-primary">Đăng ký</a>
        </div>
    </form>
@endsection
