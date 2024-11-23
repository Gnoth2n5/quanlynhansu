<?php


$data = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'role' => 'Admin', 'status' => 'Active'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'role' => 'Employee', 'status' => 'Inactive'],
    ['id' => 3, 'name' => 'Samuel Green', 'email' => 'samuel.green@example.com', 'role' => 'Manager', 'status' => 'Active'],
    ['id' => 4, 'name' => 'Alice Brown', 'email' => 'alice.brown@example.com', 'role' => 'Employee', 'status' => 'Active'],
    ['id' => 5, 'name' => 'David White', 'email' => 'david.white@example.com', 'role' => 'Employee', 'status' => 'Inactive'],
];


$columns= [
    'id' => 'ID',
    'name' => 'Name',
    'email' => 'Email',
    'role' => 'Role',
    'status' => 'Status',
];
?>

@extends('layouts.defaultLayout')

@section('title', 'Quản lý Người dùng')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3>Quản lý Người dùng</h3>
                @component('components.table.table_normal', ['columns' => $columns, 'data' => $data])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
