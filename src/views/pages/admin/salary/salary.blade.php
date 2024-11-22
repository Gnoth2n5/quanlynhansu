<?php

$data = [['id' => 1, 'user_id' => 1, 'basic_salary' => 3000, 'bonus' => 500, 'total_salary' => 3500], ['id' => 2, 'user_id' => 2, 'basic_salary' => 2500, 'bonus' => 200, 'total_salary' => 2700], ['id' => 3, 'user_id' => 3, 'basic_salary' => 3500, 'bonus' => 700, 'total_salary' => 4200], ['id' => 4, 'user_id' => 4, 'basic_salary' => 2800, 'bonus' => 400, 'total_salary' => 3200], ['id' => 5, 'user_id' => 5, 'basic_salary' => 2600, 'bonus' => 300, 'total_salary' => 2900]];

$columns = [
    'id' => 'Salary ID',
    'user_id' => 'User ID',
    'basic_salary' => 'Basic Salary',
    'bonus' => 'Bonus',
    'total_salary' => 'Total Salary',
];

?>

@extends('layouts.defaultLayout')

@section('title', 'Quản lý Lương')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3>Quản lý Lương</h3>
                @component('components.table.table_normal', ['columns' => $columns, 'data' => $data])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
