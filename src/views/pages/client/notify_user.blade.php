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
        @foreach ($data as $notify)
            <div class="col-lg-12 mb-3">
                <div class="card shadow-sm border-light" style="margin: auto;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="status-dot bg-danger"
                                style="width: 12px; height: 12px; border-radius: 50%; margin-right: 10px"></div>
                            <h5 class="card-title mb-0">{{ $notify['title'] }}</h5>
                        </div>
                        <p class="card-text mt-2">
                            {{ $notify['content'] }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">{{ $notify['created_at'] }}</small>
                            <small
                                class="text-muted">{{ $notify['type'] == 'Office' ? 'Thông báo từ phòng ban' : 'Thông báo từ hệ thống' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
