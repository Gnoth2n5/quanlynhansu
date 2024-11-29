@extends('layouts.defaultLayout')

@section('title', 'Thông tin người dùng')

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
    <div class="row mt-3">
        <!-- Profile Section -->
        <div class="col-lg-4">
            <div class="card profile-card-2">
                <div class="card-body pt-3">
                    <div class="row align-items-center">
                        <!-- Avatar -->
                        <div class="col-auto">
                            <img src="{{isset($user->avatar) ? '/uploads/avatar/' . $user->avatar : '/assets/images/faces/face1.jpg'}}" alt="User Avatar" class="profile-avatar rounded-circle"
                                style="width: 80px; height: 80px;">
                        </div>
                        <!-- Name and Role -->
                        <div class="col">
                            <h5 class="card-title mb-1">{{ $user->full_name }}</h5>
                            <p class="card-text mb-1">
                                Chức vụ:
                                @if ($user->role->name == 'admin')
                                    Quản trị viên
                                @elseif($user->role->name == 'manager')
                                    Trưởng phòng
                                @else
                                    Nhân viên
                                @endif
                            </p>
                            <p class="card-text">Thuộc:
                                @if ($user->offices->isNotEmpty())
                                    {{ $user->offices->first()->name }}
                                @else
                                    Chưa có phòng ban
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $_ENV['APP_URL'] }}/admin/update-user" enctype="multipart/form-data" method="POST">

                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <!-- UID -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">UID</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="uid" type="text" value="{{ $user->UID }}"
                                    disabled>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Họ và Tên</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="fullname" type="text" value="{{ $user->full_name }}">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Email</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="email" type="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">SĐT</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="phone" type="text" value="{{ $user->phone }}">
                            </div>
                        </div>

                        <!-- Avatar -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Avatar</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="avatar" type="file">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Địa chỉ</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="address" type="text"
                                    value="{{ $user['address'] ?? '' }}" placeholder="Địa chỉ...">
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Username</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="username" type="text" value="{{ $user->username }}">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Trạng thái</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="status">
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Đang hoạt động
                                    </option>
                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Không hoạt
                                        động</option>
                                    <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Tạm khóa
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Chức vụ</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $user->role->id == $role->id ? 'selected' : '' }}>
                                            {{ $role->name == 'admin' ? 'Quản trị viên' : ($role->name == 'manager' ? 'Trưởng phòng' : 'Nhân viên') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Office -->

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Phòng ban</label>
                            <div class="col-lg-9 select">
                                <select class="form-control office-select2" name="office" id="office-select">

                                    @if ($user->offices->isNotEmpty())
                                        <option selected value="{{ $user->offices->first()->id }}">
                                            {{ $user->offices->first()->name }}
                                        </option>
                                    @else
                                        <option selected value="0">Chưa có phòng ban</option>
                                    @endif

                                </select>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                                <input type="submit" class="btn btn-primary" value="Lưu thay đổi">
                                <a href="{{ $_ENV['APP_URL'] }}/admin/user-management" class="btn btn-info">Quay lại</a>
                            </div>
                        </div>

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
                // Bước 1: Lấy giá trị mặc định đã được chọn
                var defaultManagerId = $('.office-select2').val(); // Giá trị từ option mặc định trong HTML
                var defaultManagerText = $('.office-select2 option:selected')
                    .text(); // Text hiển thị của giá trị mặc định

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
    </script>
@endsection
