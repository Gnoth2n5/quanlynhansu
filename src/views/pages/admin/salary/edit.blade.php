@extends('layouts.defaultLayout')

@section('title', 'Sửa Bảng lương')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-3">
                    <h2 class="text-center">Sửa Bảng lương</h2>
                    <form id="createOfficeForm" action="{{ $_ENV['APP_URL'] }}/admin/update-salary" method="POST"
                        class="mt-4">

                        <input type="hidden" name="id" value="{{$salary->id}}">


                        <div class="mb-3 select">
                            <label for="nameUser" class="form-label">Tên Nhân viên</label>
                            <input type="text" class="form-control" value="{{$salary->users->full_name}}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="base" class="form-label">Lương cơ bản</label>
                            <input type="number" step="0.01" max="99999999.99" min="1" class="form-control" id="base" name="base"
                                placeholder="Nhập lương cơ bản" value="{{$salary->base_salary}}">
                        </div>

                        <div class="mb-3">
                            <label for="deductions" class="form-label">Khấu trừ</label>
                            <input type="number" step="0.01" max="99999999.99" min="0" class="form-control" id="deductions" name="deductions"
                                placeholder="Nhập khấu trừ" value="{{$salary->total_deductions}}">
                        </div>

                        <div class="mb-3">
                            <label for="bonus" class="form-label">Thưởng thêm</label>
                            <input type="number" step="0.01" max="99999999.99" min="0" class="form-control" id="bonus" name="bonus"
                                placeholder="Nhập thưởng" value="{{$salary->total_bonus}}">
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật bảng lương</button>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/salary-management" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector('#createOfficeForm');
            const baseSalary = document.querySelector("input[name='base']");
            const deductions = document.querySelector("input[name='deductions']");
            const bonus = document.querySelector("input[name='bonus']");

            // Hàm validate số
            function validateNumberField(inputElement, minValue, maxValue, errorMessage) {
                const value = parseFloat(inputElement.value.trim());
                const parent = inputElement.parentElement;

                // Xóa thông báo lỗi trước khi kiểm tra
                parent.querySelectorAll(".error-message").forEach(el => el.remove());

                if (isNaN(value) || value < minValue || value > maxValue) {
                    const errorEl = document.createElement('div');
                    errorEl.classList.add('error-message', 'text-danger', 'mt-1');
                    errorEl.textContent = errorMessage;
                    parent.appendChild(errorEl);
                    return false;
                }
                return true;
            }

            // Kiểm tra khi mất focus (blur)
            baseSalary.addEventListener('blur', function () {
                validateNumberField(baseSalary, 1, 99999999.99, "Lương cơ bản phải lớn hơn 0 và nhỏ hơn 99,999,999.99.");
            });

            deductions.addEventListener('blur', function () {
                validateNumberField(deductions, 0, 99999999.99, "Khấu trừ phải từ 0 đến 99,999,999.99.");
            });

            bonus.addEventListener('blur', function () {
                validateNumberField(bonus, 0, 99999999.99, "Thưởng phải từ 0 đến 99,999,999.99.");
            });

            // Xử lý gửi form
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Ngăn việc gửi form nếu không hợp lệ

                let isValid = true;

                // Kiểm tra các trường dữ liệu
                if (!validateNumberField(baseSalary, 1, 99999999.99, "Lương cơ bản phải lớn hơn 0 và nhỏ hơn 99,999,999.99.")) {
                    isValid = false;
                }

                if (!validateNumberField(deductions, 0, 99999999.99, "Khấu trừ phải từ 0 đến 99,999,999.99.")) {
                    isValid = false;
                }

                if (!validateNumberField(bonus, 0, 99999999.99, "Thưởng phải từ 0 đến 99,999,999.99.")) {
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
