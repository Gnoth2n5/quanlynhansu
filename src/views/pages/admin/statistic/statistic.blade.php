@extends('layouts.defaultLayout')

@section('title', 'Thống kê')

@section('style')
    <style>
        .select2-container {
            z-index: 1050;
            /* Đảm bảo dropdown hiển thị trên các thành phần khác */
        }

        .select2-selection {
            height: 45px !important;
            /* Tăng chiều cao ô nhập */
            font-size: 16px;
            /* Tăng kích thước chữ */
            display: flex;
            align-items: center;
            /* Căn giữa nội dung theo chiều dọc */
        }

        .select2-selection__rendered {
            line-height: 50px;
            /* Đồng bộ với chiều cao */
        }

        .select2-selection__choice {
            padding: 5px 10px;
            /* Tăng kích thước thẻ */
            margin: 3px;
            /* Tăng khoảng cách giữa các thẻ */
            width: 120px;
            height: 30px;
            text-align: center;
        }

        .select2-selection__choice__remove {
            font-size: 24px;
            /* Kích thước chữ nút xóa */
            margin-right: 5px;
            /* Thêm khoảng cách nút xóa */
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            font-size: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Tạo thống kê lương</h3>
        </div>
        <div class="card-body">
            <form action="{{$_ENV['APP_URL']}}/admin/statistic/create" method="POST">
                <!-- Bộ lọc -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4 select">
                        <label for="department" class="form-label fw-semibold">Chọn nhân viên</label>
                        <select class="form-select form-control employeeSelect2" id="employee" name="employee[]" multiple>
                        </select>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="selectAll" id="selectAll" type="checkbox" value="all"> Chọn tất cả
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="date_from" class="form-label fw-semibold">Từ:</label>
                        <input type="date" class="form-control" id="date_from" name="date_from">
                    </div>
                    <div class="col-md-4">
                        <label for="date_to" class="form-label fw-semibold">Đến</label>
                        <input type="date" class="form-control" id="date_to" name="date_to">
                    </div>
                </div>

                <!-- Nút xuất báo cáo -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5">Xuất báo cáo</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#selectAll').on('change', function() {
                if ($(this).is(':checked')) {
                    // Disable the select input
                    $('#employee').prop('disabled', true).val(null).trigger('change');
                } else {
                    // Enable the select input
                    $('#employee').prop('disabled', false);
                }
            });

            if ($(".employeeSelect2").length) {
                // Bước 1: Lấy giá trị mặc định đã được chọn
                var defaultManagerId = $('.employeeSelect2').val(); // Giá trị từ option mặc định trong HTML
                var defaultManagerText = $('.employeeSelect2 option:selected')
                    .text(); // Text hiển thị của giá trị mặc định

                // Bước 2: Gọi API để lấy dữ liệu
                $.ajax({
                    url: '/search-user-salary', // Đường dẫn API
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
                        $(".employeeSelect2").html(options);

                        // Bước 6: Khởi tạo hoặc làm mới Select2
                        $(".employeeSelect2").select2({
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
    </script>
@endsection
