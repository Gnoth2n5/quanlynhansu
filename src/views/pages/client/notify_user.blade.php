@extends('layouts.defaultLayout')

@section('title', 'Bảng thông báo')

@section('style')
    <style>
        .card-body:hover {
            border: 1px solid rgb(255, 18, 18);
        }

        .card-body {
            border: 1px solid transparent;
            transition: border 0.3s;
            border-radius: 1.4rem;
        }
    </style>
@endsection

@section('content')
    <div class="row">

        <div class="col-12 mb-3">
            <div class="d-flex justify-content-start align-items-center">
                <div class="d-flex align-items-center" style="margin-right: 2rem;">
                    <div class="status-dot bg-danger"
                        style="width: 12px; height: 12px; border-radius: 50%; margin-right: 10px;"></div>
                    <span class="fw-semibold">Chưa đọc</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="status-dot bg-success"
                        style="width: 12px; height: 12px; border-radius: 50%; margin-right: 10px;"></div>
                    <span class="fw-semibold">Đã đọc</span>
                </div>
            </div>
        </div>


        @if (count($data) == 0)
            <div class="col-lg-12 mb-3">
                <div class="card shadow-sm border-light" style="margin: auto;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title
                                mb-0">Không có thông báo mới</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @foreach ($data as $notify)
            <div class="col-lg-12 mb-3">
                <div class="card shadow-sm border-light" style="margin: auto;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @if (!($notify['isRead'] == 1))
                                    <div class="status-dot bg-danger"
                                        style="width: 12px; height: 12px; border-radius: 50%; margin-right: 10px"></div>
                                @else
                                    <div class="status-dot bg-success"
                                        style="width: 12px; height: 12px; border-radius: 50%; margin-right: 10px"></div>
                                @endif

                                <h5 class="card-title mb-0">{{ $notify['title'] }}</h5>
                            </div>
                            <div>
                                <a href="{{ $_ENV['APP_URL'] }}/user/notification/show/{{ $notify['id'] }}"
                                    class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">{{ formattedDate($notify['created_at']) }}</small>
                            <small
                                class="text-muted">{{ $notify['type'] == 'office' ? 'Thông báo từ phòng ban' : 'Thông báo từ hệ thống' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
