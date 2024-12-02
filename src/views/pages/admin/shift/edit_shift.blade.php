@extends('layouts.defaultLayout')

@section('title', 'Chỉnh sửa ca làm việc')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Sửa Ca Làm Việc</h2>
                    <form action="{{$_ENV['APP_URL']}}/admin/update-shift/{{$shift->id}}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{$shift->id}}">

                        <div class="mb-3">
                            <label for="shiftName" class="form-label">Tên ca</label>
                            <input type="text" class="form-control" value="{{$shift->name}}" id="shiftName" name="shiftName" placeholder="Nhập tên ca" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Giờ bắt đầu</label>
                            <input type="time" class="form-control" value="{{$shift->start_time}}" id="startTime" name="startTime" required>
                        </div>

                        <div class="mb-3">
                            <label for="endTime" class="form-label">Giờ kết thúc</label>
                            <input type="time" class="form-control" value="{{$shift->end_time}}" id="endTime" name="endTime" required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Thêm ghi chú (nếu có)">{{$shift->notes}}</textarea>
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                        <a href="{{$_ENV['APP_URL']}}/admin/shift-management" class="btn btn-info">Quay lại</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('#shiftForm');
        const shiftName = document.querySelector("input[name='shiftName']");
        const startTime = document.querySelector("input[name='startTime']");
        const endTime = document.querySelector("input[name='endTime']");

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
        shiftName.addEventListener('blur', function() {
            validateField(shiftName, 3, "Tên ca không được để trống và phải chứa ít nhất 3 ký tự.");
        });

        startTime.addEventListener('blur', function() {
            validateField(startTime, 5, "Giờ bắt đầu không được để trống và phải hợp lệ (HH:mm).");
        });

        endTime.addEventListener('blur', function() {
            validateField(endTime, 5, "Giờ kết thúc không được để trống và phải hợp lệ (HH:mm).");
        });

        // Xử lý gửi form
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Ngăn việc gửi form nếu không hợp lệ

            let isValid = true;

            // Kiểm tra lại tất cả các trường trước khi gửi
            if (!validateField(shiftName, 3, "Tên ca không được để trống và phải chứa ít nhất 3 ký tự.")) {
                isValid = false;
            }

            if (!validateField(startTime, 5, "Giờ bắt đầu không được để trống và phải hợp lệ (HH:mm).")) {
                isValid = false;
            }

            if (!validateField(endTime, 5, "Giờ kết thúc không được để trống và phải hợp lệ (HH:mm).")) {
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
