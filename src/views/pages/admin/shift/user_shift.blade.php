@extends('layouts.defaultLayout')

@section('title', 'Phân ca')

@php
    $i = 1;
@endphp

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <h3>Phân ca</h3>
                </div>

                <div class="table-responsive mb-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>UID</th>
                                <th>Ca làm việc</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $user)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{$user->shift[0]->shift_name ?? "Chưa có ca làm việc"}}</td>                                   
                                    <td>
                                        <a href="{{ $_ENV['APP_URL'] }}/admin/shift-division/{{ $user->id }}"
                                            class="btn btn-info btn-sm">Phân ca</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @component('components.pagination.pagination', [
                    'currentPage' => $currentPage,
                    'totalPages' => $totalPages,
                ])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
