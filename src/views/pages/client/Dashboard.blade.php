@extends('layouts.defaultLayout')

@section('title', 'Dashboard')

@section('content')
    <div class="card border-light shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title text-primary" id="greeting-title">
                    <!-- Nội dung sẽ được thay đổi theo thời gian -->
                </h4>
                <p class="card-text" id="greeting-message">
                    <!-- Lời chào sẽ được thay đổi theo thời gian -->
                </p>
            </div>
            <div>
                <img src="" alt="Greeting Image" id="greeting-img" style="width: 50px; height: 50px;">
            </div>
        </div>
    </div>

    <div class="card border-primary mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            @if (!$isCheckIn)
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h4 class="card-title text-danger me-3">
                        <i class="fas fa-exclamation-triangle"></i> Bạn chưa chấm công hôm nay.
                        <strong>Vui lòng chấm công để ghi nhận thời gian làm việc của bạn.</strong>
                    </h4>
                    <a href="{{ $_ENV['APP_URL'] }}/user/check-in" class="btn btn-success">
                        <i class="fas fa-sign-in-alt"></i> Check In
                    </a>
                </div>
            @else
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h4 class="card-title text-success me-3">
                        <i class="fas fa-check-circle"></i> Bạn đã chấm công hôm nay.
                    </h4>
                    <div>
                        <a href="{{ $_ENV['APP_URL'] }}/user/register-ot" class="btn btn-primary"
                        onclick="SweetAlert(event, 'Bạn có muốn đăng kí OT không?', 'warning', {confirmBtn: true, cancelBtn: true})"
                        >
                            Đăng kí OT
                        </a>
                        @if (!$isCheckOut)
                            <a href="{{ $_ENV['APP_URL'] }}/user/check-out" class="btn btn-danger"
                                onclick="handleCheckOut(event, this)">
                                <i class="fas fa-sign-out-alt"></i> Check Out
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-light-danger',
                'title' => 'Tổng số ngày đã chấm công',
                'value' => $atteMonth,
                'percentage' => '0%',
                'period' => '30 ngày',
            ])
            @endcomponent
        </div>
        <div class="col-md-6 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-tale',
                'title' => 'Số ngày chấm công muộn',
                'value' => $atteLate,
                'percentage' => '0%',
                'period' => '30 ngày',
            ])
            @endcomponent
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            handleCheckOut = (event, element) => {
                event.preventDefault();

                const url = element.getAttribute('href');

                $.ajax({
                    url: '/user/is-early',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.isEarly) {
                            SweetAlert(event,
                                'Chưa hết ca làm việc, bạn có chắc muốn checkout ngay bây giờ không?',
                                'warning', {
                                    element: element,
                                    confirmBtn: true,
                                    cancelBtn: true
                                });
                        } else {
                            SweetAlert(event,
                                'Đã hết ca làm việc của bạn, bạn có chắc muốn checkout ngay bây giờ không?',
                                'warning', {
                                    element: element,
                                    confirmBtn: true,
                                    cancelBtn: true
                                });
                        }
                    }
                })
            }
        });
    </script>
@endsection
