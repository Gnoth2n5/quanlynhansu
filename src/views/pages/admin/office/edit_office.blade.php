@extends('layouts.defaultLayout')

@section('title', 'Chỉnh sửa phòng ban')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Sửa Phòng</h2>
                    <form action="" method="POST" class="mt-4">
                        <input type="hidden" name="id" value="{{$office->id}}">
                        <div class="mb-3">
                            <label for="roomName" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control" value="{{$office->name}}" id="roomName" name="roomName" placeholder="Nhập tên phòng" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="location" class="form-label">Vị trí</label>
                            <input type="text" class="form-control" value="{{$office->location}}" id="location" name="location" placeholder="Nhập vị trí" required>
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                        <a href="{{$_ENV['APP_URL']}}/admin/office-management" class="btn btn-info">Quay lại</a>
                    </form>
                

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector('#editOfficeForm');
            const roomName = document.querySelector("input[name='roomName']");
            const location = document.querySelector("input[name='location']");

            // Function để kiểm tra hợp lệ và hiển thị lỗi
            function validateField(inputElement, minLength, errorMessage) {
                const value = inputElement.value.trim();
                const parent = inputElement.parentElement;

                // Xóa thông báo lỗi trước khi kiểm tra
                parent.querySelectorAll(".error-message").forEach(el => el.remove());

                if (value === "" || value.length < minLength) {
                    const errorEl = document.createElement('div');
                    errorEl.classList.add('error-message', 'text-danger', 'mt-1');
                    errorEl.textContent = errorMessage;
                    parent.appendChild(errorEl);
                    return false;
                }
                return true;
            }

            // Kiểm tra khi mất focus (blur)
            roomName.addEventListener('blur', function () {
                validateField(roomName, 3, "Tên phòng không được để trống và phải chứa ít nhất 3 ký tự.");
            });

            location.addEventListener('blur', function () {
                validateField(location, 3, "Vị trí không được để trống và phải chứa ít nhất 3 ký tự.");
            });

            // Xử lý gửi form
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Ngăn việc gửi form nếu không hợp lệ

                let isValid = true;
                // Kiểm tra lại tất cả các trường trước khi gửi
                if (!validateField(roomName, 3, "Tên phòng không được để trống và phải chứa ít nhất 3 ký tự.")) {
                    isValid = false;
                }

                if (!validateField(location, 3, "Vị trí không được để trống và phải chứa ít nhất 3 ký tự.")) {
                    isValid = false;
                }

                // Nếu hợp lệ, gửi form
                if (isValid) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
