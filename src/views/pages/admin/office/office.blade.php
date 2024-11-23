<?php

$columns = [
    'id' => 'ID',
    'name' => 'Tên',
    'location' => 'Vị trí',
 
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
