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
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Mật khẩu">
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
        <div class="form-group">
            <input type="text" name="username" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
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

@section('script')
    <script>
        const form = document.querySelector('form');
        const username = document.querySelector("input[name='username']");
        const email = document.querySelector("input[name='email']");
        const password = document.querySelector("input[name='password']");
        const fullName = document.querySelector("input[name='full_name']");
        const confirmPassword = document.querySelector("input[name='confirm_password']");
        const birthday = document.querySelector("input[name='birthday']");
        const gender = document.querySelector("select[name='gender']");
        const termsCheckbox = document.querySelector("input[type='checkbox']")
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            let isValid = true;
            let errors = [];

            document.querySelectorAll(".error-message").forEach(el => el.remove());

            if (username.value.trim() === "" || username.value.length < 4 || username.value.length > 20) {
                isValid = false;
                errors.push({
                    field: username,
                    message: "Username phải từ 4 đến 20 ký tự."
                });
            }

            if (!/\S+@\S+\.\S+/.test(email.value.trim())) {
                isValid = false;
                errors.push({
                    field: email,
                    message: "Email không hợp lệ."
                });
            }
            if (fullName.value.trim() === "" || fullName.value.length < 2) {
                isValid = false;
                errors.push({
                    field: fullName,
                    message: "Họ và tên phải chứa ít nhất 2 ký tự."
                });
            }

            if (password.value.length < 6) {
                isValid = false;
                errors.push({
                    field: password,
                    message: "Password phải ít nhất 6 ký tự."
                });
            }

            if (confirmPassword.value !== password.value|| confirmPassword.value =="") {
                isValid = false;
                errors.push({
                    field: confirmPassword,
                    message: "Mật khẩu xác nhận không khớp."
                });
            }

            if (!birthday.value) {
                isValid = false;
                errors.push({
                    field: birthday,
                    message: "Bạn phải nhập ngày sinh."
                });
            }

            if (!termsCheckbox.checked) {
                isValid = false;
                errors.push({
                    field: termsCheckbox,
                    message: "Bạn phải đồng ý với các điều khoản."
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
