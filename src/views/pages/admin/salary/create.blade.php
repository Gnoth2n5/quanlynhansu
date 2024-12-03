@extends('layouts.defaultLayout')

@section('title', 'Tạo Bảng lương')

@section('style')
    <style>
        .select2-container {
            z-index: 1050;
            /* Đảm bảo dropdown hiển thị trên các thành phần khác */
        }

        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            /* Điều chỉnh chiều cao khớp với Bootstrap input */
            border: 1px solid #ced4da;
            /* Giữ viền đồng bộ với input */
            border-radius: 0.25rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(0.8rem);
            /* Căn giữa văn bản */
        }
    </style>
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-3">
                    <h2 class="text-center">Tạo Bảng lương</h2>
                    <form id="createOfficeForm" action="{{ $_ENV['APP_URL'] }}/admin/store-salary" method="POST"
                        class="mt-4">

                        <div class="mb-3 select">
                            <label for="nameUser" class="form-label">Tên Nhân viên</label>
                            <select name="userId" class="form-control form-select-lg user-select2" id="">
                                <option value="0" selected>Chọn Nhân viên</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="base" class="form-label">Lương cơ bản</label>
                            <input type="number" step="0.01" max="99999999.99" min="1" class="form-control"
                                id="base" name="base" placeholder="Nhập lương cơ bản">
                        </div>

                        <div class="mb-3">
                            <label for="deductions" class="form-label">Khấu trừ</label>
                            <input type="number" step="0.01" max="99999999.99" min="0" class="form-control"
                                id="deductions" name="deductions" placeholder="Nhập khấu trừ">
                        </div>

                        <div class="mb-3">
                            <label for="bonus" class="form-label">Thưởng thêm</label>
                            <input type="number" step="0.01" max="99999999.99" min="0" class="form-control"
                                id="bonus" name="bonus" placeholder="Nhập thưởng">
                        </div>

                        <button type="submit" class="btn btn-primary">Tạo bảng lương</button>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/salary-management" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            if ($(".user-select2").length) {
                // Bước 1: Lấy giá trị mặc định đã được chọn
                var defaultManagerId = $('.user-select2').val(); // Giá trị từ option mặc định trong HTML
                var defaultManagerText = $('.user-select2 option:selected')
                    .text(); // Text hiển thị của giá trị mặc định

                // Bước 2: Gọi API để lấy dữ liệu
                $.ajax({
                    url: '/search-user-manager', // Đường dẫn API
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (!data || !Array.isArray(data)) {
                            console.error("Dữ liệu API không hợp lệ.");
                            return;
                        }

                        var options = '';

                        // Bước 3: Thêm giá trị mặc định nếu chưa có trong dữ liệu API
                        if (defaultManagerId && defaultManagerText) {
                            options += `
        <option value="${defaultManagerId}" selected>
          ${defaultManagerText}
        </option>`;
                        }

                        // Bước 4: Thêm các option từ API
                        $.each(data, function(key, user) {
                            if (user.id !=
                                defaultManagerId) { // Tránh thêm lại giá trị mặc định
                                options += `
          <option value="${user.id}">
            ${user.text}
          </option>`;
                            }
                        });

                        // Bước 5: Gắn các option mới vào select
                        $(".user-select2").html(options);

                        // Bước 6: Khởi tạo hoặc làm mới Select2
                        $(".user-select2").select2({
                            placeholder: "Chọn Nhân viên",
                            dropdownParent: $(".select"),
                        });
                    },
                    error: function() {
                        console.error("Lỗi khi tải dữ liệu từ API.");
                    }
                });
            }
        });
        const form = document.querySelector('#createOfficeForm');
            const userId = document.querySelector("select[name='userId']");
            const baseSalary = document.querySelector("input[name='base']");
            const deductions = document.querySelector("input[name='deductions']");
            const bonus = document.querySelector("input[name='bonus']");

            function validateSelectField(selectElement, errorMessage) {
                const value = selectElement.value;
                const parent = selectElement.parentElement;

                parent.querySelectorAll(".error-message").forEach(el => el.remove());

                if (value === "0" || value === "") {
                    const errorEl = document.createElement('div');
                    errorEl.classList.add('error-message', 'text-danger', 'mt-1');
                    errorEl.textContent = errorMessage;
                    parent.appendChild(errorEl);
                    return false;
                }
                return true;
            }

            function validateNumberField(inputElement, minValue, maxValue, errorMessage) {
                const value = parseFloat(inputElement.value.trim());
                const parent = inputElement.parentElement;

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

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                let isValid = true;

                if (!validateSelectField(userId, "Vui lòng chọn Nhân viên.")) {
                    isValid = false;
                }

                if (!validateNumberField(baseSalary, 1, 99999999.99, "Lương cơ bản phải lớn hơn 0 và nhỏ hơn 99,999,999.99.")) {
                    isValid = false;
                }

                if (!validateNumberField(deductions, 0, 99999999.99, "Khấu trừ phải từ 0 đến 99,999,999.99.")) {
                    isValid = false;
                }

                if (!validateNumberField(bonus, 0, 99999999.99, "Thưởng phải từ 0 đến 99,999,999.99.")) {
                    isValid = false;
                }

                if (isValid) {
                    form.submit();
                }
            });
    </script>
@endsection
