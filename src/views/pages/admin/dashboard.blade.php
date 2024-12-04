@extends('layouts.defaultLayout')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-3 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-tale',
                'title' => 'Tổng số nhân viên',
                'value' => $totalUser,
                'percentage' => '00.00%',
                'period' => 'Toàn thời gian',
            ])
            @endcomponent
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-dark',
                'title' => 'Chấm công muộn',
                'value' => $totalCheckInLate,
                'percentage' => '00.00%',
                'period' => '30 ngày',
            ])
            @endcomponent
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-light-blue',
                'title' => 'Tổng số thông báo',
                'value' => $totalNotify,
                'percentage' => '00.00%',
                'period' => '30 ngày',
            ])
            @endcomponent
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-light-danger',
                'title' => 'Tổng số đơn từ đang chờ xác nhận',
                'value' => $totalLeaveRequest,
                'percentage' => '00.00%',
                'period' => '7 ngày',
            ])
            @endcomponent
        </div>
    </div>

    <div class="row h-25">

        <div class="col-md-12 grid-margin stretch-card">
            @component('components.chart.chart_one', [
                'totalCheckIn' => $totalCheckIn,
                'checkInLate' => $totalCheckInLate,
                'checkInOnTime' => $totalCheckInOnTime,
            ])
            @endcomponent
        </div>
    </div>
@endsection
