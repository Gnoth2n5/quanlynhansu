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
        <!-- Form Section -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Cài đặt hệ thống</h4>
                </div>
                <div class="card-body">
                    <form action="{{ $_ENV['APP_URL'] }}/admin/system-setting/update" method="POST">

                        <!-- Avatar -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">IP mạng nội bộ</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="ip" type="text" value="{{ $settingIps }}">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Tỉ lệ OT</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="ot" type="text" value="{{$ot}}">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                                <input type="submit" class="btn btn-primary" value="Lưu thay đổi">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
