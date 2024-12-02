@extends('layouts.defaultLayout')

@section('title', 'Tạo ca làm việc')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Tạo Ca Làm Việc Mới</h2>
                    <form action="{{$_ENV['APP_URL']}}/admin/store-shift" method="POST" class="mt-4">
                        
                        <div class="mb-3">
                            <label for="shiftName" class="form-label">Tên ca</label>
                            <input type="text" class="form-control" id="shiftName" name="shiftName" placeholder="Nhập tên ca" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Giờ bắt đầu</label>
                            <input type="time" class="form-control" id="startTime" name="startTime" required>
                        </div>

                        <div class="mb-3">
                            <label for="endTime" class="form-label">Giờ kết thúc</label>
                            <input type="time" class="form-control" id="endTime" name="endTime" required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Thêm ghi chú (nếu có)"></textarea>
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Tạo ca</button>
                        <a href="{{$_ENV['APP_URL']}}/admin/shift-management" class="btn btn-secondary">Quay lại</a>
                    </form>
                
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form[action*='/admin/store-shift']");
            const shiftName = document.querySelector("input[name='shiftName']");
            const startTime = document.querySelector("input[name='startTime']");
            const endTime = document.querySelector("input[name='endTime']");
            const overtimeYes = document.getElementById("overtimeYes");
            const overtimeNo = document.getElementById("overtimeNo");

            // Hàm kiểm tra hợp lệ và hiển thị lỗi
            function validateField(inputElement, minLength, errorMessage) {
                const value = inputElement.value.trim();
                const parent = inputElement.parentElement;

                // Xóa thông báo lỗi cũ
                parent.querySelectorAll(".error-message").forEach(el => el.remove());

                if (value === "" || value.length < minLength) {
                    const errorEl = document.createElement("div");
                    errorEl.classList.add("error-message", "text-danger", "mt-1");
                    errorEl.textContent = errorMessage;
                    parent.appendChild(errorEl);
                    return false;
                }
                return true;
            }

            // Hàm kiểm tra thời gian
            function validateTime(inputElement, errorMessage) {
                const value = inputElement.value.trim();
                const parent = inputElement.parentElement;

                // Xóa thông báo lỗi cũ
                parent.querySelectorAll(".error-message").forEach(el => el.remove());

                const timePattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/; // Định dạng HH:mm
                if (!timePattern.test(value)) {
                    const errorEl = document.createElement("div");
                    errorEl.classList.add("error-message", "text-danger", "mt-1");
                    errorEl.textContent = errorMessage;
                    parent.appendChild(errorEl);
                    return false;
                }
                return true;
            }

            // Kiểm tra khi mất focus (blur)
            shiftName.addEventListener("blur", function() {
                validateField(shiftName, 3, "Tên ca không được để trống và phải chứa ít nhất 3 ký tự.");
            });

            // Xử lý gửi form
            form.addEventListener("submit", function(event) {
                event.preventDefault(); // Ngăn gửi form nếu không hợp lệ

                let isValid = true;

                // Kiểm tra tất cả các trường
                if (!validateField(shiftName, 3,
                    "Tên ca không được để trống và phải chứa ít nhất 3 ký tự.")) {
                    isValid = false;
                }

                // Kiểm tra lựa chọn overtime
                if (!overtimeYes.checked && !overtimeNo.checked) {
                    const overtimeGroup = document.querySelector("div.mb-4");
                    overtimeGroup.querySelectorAll(".error-message").forEach(el => el.remove());

                    const errorEl = document.createElement("div");
                    errorEl.classList.add("error-message", "text-danger", "mt-1");
                    errorEl.textContent = "Vui lòng chọn tùy chọn Overtime.";
                    overtimeGroup.appendChild(errorEl);
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
