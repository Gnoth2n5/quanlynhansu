@extends('layouts.defaultLayout')

@section('title', 'Tạo thông báo')

@section('style')
    <style>
        .select2-container {
            z-index: 1050;
            /* Đảm bảo dropdown hiển thị trên các thành phần khác */
        }

        .select2-selection {
            height: 50px !important;
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
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-2">
                    <h2 class="text-center">Sửa Thông Báo</h2>
                    <form action="{{ $_ENV['APP_URL'] }}/admin/update-notify" method="POST" class="mt-4">

                        <input type="hidden" value="{{ $notify->id }}" name="id">

                        <div class="mb-4">
                            <label for="shiftName" class="form-label fw-bold">Tiêu đề</label>
                            <input type="text" class="form-control form-control-lg" id="title" name="title"
                                placeholder="Nhập tiêu đề" required value="{{ $notify->title }}">
                        </div>

                        <div class="mb-4">
                            <label for="shiftName" class="form-label fw-bold">Nội dung</label>
                            <textarea class="form-control form-control-lg" id="content" name="content" rows="5" placeholder="Nhập nội dung"
                                required>
                            {{ $notify->message }}
                            </textarea>
                        </div>

                        <div class="mb-4 select form-group">
                            <label for="toUser" class="form-label fw-bold">Đến phòng ban</label>
                            <select class="form-control office-select2" name="office[]" id="office-select" multiple>
                                @foreach ($notify->offices as $office)
                                    <option value="{{ $office->id }}" selected>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Sửa thông báo</button>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/notify-management" class="btn btn-secondary">Quay lại</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            if ($(".office-select2").length) {
                // Bước 1: Lấy tất cả giá trị mặc định đã được chọn (dành cho multiple)
                var defaultManagerIds = $('.office-select2').val(); // Giá trị đã chọn trong HTML (là một mảng)
                var defaultManagerText = []; // Mảng chứa tên phòng ban đã chọn

                // Lấy tên các phòng ban đã chọn
                $('.office-select2 option:selected').each(function() {
                    defaultManagerText.push($(this).text().trim()); // Đưa tên phòng ban vào mảng
                });

                // Bước 2: Gọi API để lấy dữ liệu
                $.ajax({
                    url: '/search-office', // Đường dẫn API
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (!data || !Array.isArray(data)) {
                            console.error("Dữ liệu API không hợp lệ.");
                            return;
                        }

                        var options = '';

                        // Bước 3: Thêm các giá trị mặc định vào options (nếu chưa có trong dữ liệu API)
                        $.each(defaultManagerIds, function(index, managerId) {
                            // Tìm kiếm tên phòng ban từ mảng dữ liệu mặc định
                            var managerText = defaultManagerText[index];
                            options += `
                        <option value="${managerId}" selected>
                            ${managerText}
                        </option>`;
                        });

                        // Bước 4: Thêm các option từ API (tránh trùng với giá trị đã chọn)
                        $.each(data, function(key, office) {
                            if (defaultManagerIds.indexOf(office.id.toString()) === -
                                1) { // Tránh thêm lại giá trị mặc định
                                options += `
                            <option value="${office.id}">
                                ${office.text}
                            </option>`;
                            }
                        });

                        // Bước 5: Gắn các option mới vào select
                        $(".office-select2").html(options);

                        // Bước 6: Khởi tạo hoặc làm mới Select2
                        $(".office-select2").select2({
                            placeholder: "Chọn Phòng Ban",
                            dropdownParent: $(".select"),
                        });
                    },
                    error: function() {
                        console.error("Lỗi khi tải dữ liệu từ API.");
                    }
                });
            }
        });

        const form = document.querySelector('form');
        const title = document.querySelector("input[name='title']");
        const content = document.querySelector("textarea[name='content']");
        const officeSelect = document.querySelector(".office-select2");

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            let isValid = true;

            // Kiểm tra từng trường
            if (!validateTextField(title, "Tiêu đề không được để trống.")) {
                isValid = false;
            }

            if (!validateTextField(content, "Nội dung không được để trống.")) {
                isValid = false;
            }

            if (!validateSelectField(officeSelect, "Vui lòng chọn ít nhất một phòng ban.")) {
                isValid = false;
            }

            // Gửi form nếu tất cả các trường hợp lệ
            if (isValid) {
                form.submit();
            }
        });


    </script>
@endsection
