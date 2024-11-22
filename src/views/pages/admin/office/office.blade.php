<?php

// Dữ liệu phòng
$data = [
    [
        'room_id' => '101',
        'room_name' => 'Deluxe Room',
        'status' => 'Available',
        'department_manager' => 'Admin',
    ],
    [
        'room_id' => '102',
        'room_name' => 'Standard Room',
        'status' => 'Occupied',
        'department_manager' => 'Admin',
    ],
    [
        'room_id' => '103',
        'room_name' => 'Suite Room',
        'status' => 'Available',
        'department_manager' => 'Admin',
    ],
    [
        'room_id' => '104',
        'room_name' => 'Economy Room',
        'status' => 'Under Maintenance',
        'department_manager' => 'Admin',
    ],
];

$columns = [
    'room_id' => 'ID',
    'room_name' => 'Tên',
    'status' => 'Trạng thái',
    'department_manager' => 'Trưởng phòng',
];
?>

@extends('layouts.defaultLayout')

@section('title', 'Quản lý phòng ban')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3>Quản lý phòng ban</h3>
                @component('components.table.table_normal', ['columns' => $columns, 'data' => $data])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
