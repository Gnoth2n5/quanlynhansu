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
            Bạn chưa có tài khoản? <a href="<?= $_ENV['APP_URL'] ?>/signup" class="text-primary">Đăng ký</a>
        </div>
    </form>
@endsection
@section('script')
    <script>
        const form = document.querySelector('#createOfficeForm');
        const roomName = document.querySelector("input[name='roomName']");
        const location = document.querySelector("input[name='location']");

        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Ngăn chặn gửi form nếu chưa hợp lệ
            let isValid = true;
            let errors = [];

            // Xóa các thông báo lỗi trước đó
            document.querySelectorAll(".error-message").forEach(el => el.remove());

            // Kiểm tra tên phòng
            if (roomName.value.trim() === "" || roomName.value.length < 3) {
                isValid = false;
                errors.push({
                    field: roomName,
                    message: "Tên phòng không được để trống và phải chứa ít nhất 3 ký tự."
                });
            }

            // Kiểm tra vị trí
            if (location.value.trim() === "" || location.value.length < 3) {
                isValid = false;
                errors.push({
                    field: location,
                    message: "Vị trí không được để trống và phải chứa ít nhất 3 ký tự."
                });
            }

            // Nếu có lỗi, hiển thị lỗi và không gửi form
            if (!isValid) {
                errors.forEach(error => {
                    const errorEl = document.createElement('div');
                    errorEl.classList.add('error-message', 'text-danger', 'mt-1');
                    errorEl.textContent = error.message;
                    error.field.parentElement.appendChild(errorEl);
                });
                return;
            }

            // Nếu hợp lệ, gửi form
            form.submit();
        });
    </script>
@endsection
