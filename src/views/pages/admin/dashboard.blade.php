@extends('layouts.defaultLayout')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-3 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-tale',
                'title' => 'Tổng số nhân viên',
                'value' => '4.006',
                'percentage' => 'Tăng 10.00%',
                'period' => '30 ngày',
            ])
            @endcomponent
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-dark',
                'title' => 'Chấm công muộn',
                'value' => '20',
                'percentage' => 'Giảm 5.00%',
                'period' => '30 ngày',
            ])
            @endcomponent
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-light-blue',
                'title' => 'Tổng số thông báo',
                'value' => '20',
                'percentage' => 'Giảm 5.00%',
                'period' => '7 ngày',
            ])
            @endcomponent
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            @component('components.datastats.datastats', [
                'cardClass' => 'card-light-danger',
                'title' => 'Tổng số đơn từ',
                'value' => '20',
                'percentage' => 'Giảm 5.00%',
                'period' => '30 ngày',
            ])
            @endcomponent
        </div>
    </div>

    <div class="row h-25">
        <div class="col-md-6 grid-margin stretch-card">
            @component('components.chart.chart_one')
            @endcomponent
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            @component('components.chart.chart_two')
            @endcomponent
        </div>
    </div>
@endsection
