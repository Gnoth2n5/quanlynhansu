@extends('layouts.authLayout')

@section('title', 'Đăng nhập')

@section('content')
    <h4>Hello! let's get started</h4>
    <h6 class="font-weight-light">Đăng nhập để tiếp tục.</h6>
    <form class="pt-3" id="loginForm" method="POST" action="<?= $_ENV['APP_URL'] ?>/login">
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
            Bạn chưa có tài khoản? <a href="<?= $_ENV['APP_URL'] ?>/signup" class="text-primary">Đăng ký</a>
        </div>
    </form>
@endsection

@section('script')
    <script>
        const form = document.querySelector('#loginForm');
        const email = document.querySelector("input[name='email']");
        const password = document.querySelector("input[name='password']");

        form.addEventListener("submit", function(event) {
            event.preventDefault();

            let isValid = true;
            let errors = [];

            document.querySelectorAll(".error-message").forEach(el => el.remove());

            if (!/\S+@\S+\.\S+/.test(email.value.trim())) {
                isValid = false;
                errors.push({
                    field: email,
                    message: "Email không hợp lệ. Vui lòng nhập email đúng định dạng."
                });
            }

            if (password.value.trim() === "" || password.value.length < 6) {
                isValid = false;
                errors.push({
                    field: password,
                    message: "Mật khẩu phải nhập chính xác."
                });
            }

            if (!isValid) {
                errors.forEach(error => {
                    const errorEl = document.createElement('div');
                    errorEl.classList.add('error-message', 'text-danger', 'mt-1');
                    errorEl.textContent = error.message;
                    error.field.parentElement.appendChild(errorEl);
                });

                return;
            }

            form.submit();
        });
    </script>
@endsection
