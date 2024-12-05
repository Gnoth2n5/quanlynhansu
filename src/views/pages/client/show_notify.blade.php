@extends('layouts.defaultLayout')

@section('title', 'Chi tiết thông báo')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $notify->title }}</h5>
            </div>
            <div class="card-body">
                <!-- Tiêu đề -->
                <h4 class="card-title text-primary" id="notification-title">{{ $notify->title }}</h4>
                <!-- Nội dung -->
                <p class="card-text" id="notification-content">
                    {{ $notify->message }}
                </p>
                <!-- Ngày -->
                <p class="text-muted" id="notification-date">Ngày gửi: {{ $notify->updated_at }}</p>
                <!-- Nút quay lại -->
                <a href="{{ $_ENV['APP_URL'] }}/user/notification" class="btn btn-secondary">Quay Lại</a>
            </div>
        </div>
    </div>
@endsection
