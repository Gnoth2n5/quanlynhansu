<?php


$data = [
    ['id' => 1, 'user_id' => 1, 'start_date' => '2024-12-01', 'end_date' => '2024-12-05', 'reason' => 'Vacation', 'status' => 'Approved'],
    ['id' => 2, 'user_id' => 2, 'start_date' => '2024-12-10', 'end_date' => '2024-12-12', 'reason' => 'Sick Leave', 'status' => 'Pending'],
    ['id' => 3, 'user_id' => 3, 'start_date' => '2024-12-15', 'end_date' => '2024-12-17', 'reason' => 'Family Emergency', 'status' => 'Denied'],
    ['id' => 4, 'user_id' => 4, 'start_date' => '2024-12-20', 'end_date' => '2024-12-22', 'reason' => 'Personal Leave', 'status' => 'Approved'],
    ['id' => 5, 'user_id' => 5, 'start_date' => '2024-12-25', 'end_date' => '2024-12-28', 'reason' => 'Vacation', 'status' => 'Pending'],
];


$columns = [
    'id' => 'Request ID',
    'user_id' => 'User ID',
    'start_date' => 'Start Date',
    'end_date' => 'End Date',
    'reason' => 'Reason',
    'status' => 'Status',
];
?>

@extends('layouts.defaultLayout')

@section('title', 'Quản lý Đơn từ')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3>Quản lý Đơn từ</h3>
                @component('components.table.table_normal', ['columns' => $columns, 'data' => $data])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
