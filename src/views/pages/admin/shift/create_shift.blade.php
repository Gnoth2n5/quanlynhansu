@extends('layouts.defaultLayout')

@section('title', 'Tạo ca làm việc')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Tạo Ca Làm Việc Mới</h2>
                    <form action="{{ $_ENV['APP_URL'] }}/admin/store-shift" method="POST" class="mt-4">

                        <div class="mb-4">
                            <label for="shiftName" class="form-label fw-bold">Tên ca</label>
                            <input type="text" class="form-control form-control-lg" id="shiftName" name="shiftName"
                                placeholder="Nhập tên ca" required>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="startTime" class="form-label fw-bold">Giờ bắt đầu</label>
                                <input type="text" class="form-control form-control-lg timepicker" id="startTime"
                                    name="startTime" required>
                            </div>
                            <div class="col-md-6">
                                <label for="endTime" class="form-label fw-bold">Giờ kết thúc</label>
                                <input type="text" class="form-control form-control-lg timepicker" id="endTime"
                                    name="endTime" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Overtime</label>
                            <div>
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label" for="overtimeYes">
                                        Có
                                        <input class="form-check-input" type="radio" name="isOvertime" id="overtimeYes"
                                            value="1">
                                    </label>
                                </div>
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label" for="overtimeNo">
                                        Không
                                        <input class="form-check-input" type="radio" name="isOvertime" id="overtimeNo"
                                            value="0" checked>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Tạo ca</button>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/shift-management" class="btn btn-secondary">Quay lại</a>
                    </form>

                </div>
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
