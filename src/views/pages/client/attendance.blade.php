@extends('layouts.defaultLayout')

@section('title', 'Bảng chấm công')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <h3>Bảng chấm công</h3>
                </div>

                @php $i = 1 @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Thời gian Check in</th>
                            <th>Trạng thái Check in</th>
                            <th>Thời gian Check out</th>
                            <th>Trạng thái Check out</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $attendance)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $attendance->check_in }}</td>
                                <td class="text-light">
                                    @if ($attendance->check_in_status === 'on_time')
                                        <span class="badge bg-success">Đúng giờ</span>
                                    @elseif ($attendance->check_in_status === 'late')
                                        <span class="badge bg-warning text-dark">Muộn</span>
                                    @elseif ($attendance->check_in_status === 'absent')
                                        <span class="badge bg-danger">Vắng</span>
                                    @endif
                                </td>
                                <td>{{ $attendance->check_out }}</td>
                                <td class="text-light">
                                    @if ($attendance->check_out_status == 'on_time')
                                        <span class="badge bg-success">Đúng giờ</span>
                                    @elseif ($attendance->check_out_status == 'early_exit')
                                        <span class="badge bg-warning text-dark">Ra sớm</span>
                                    @elseif ($attendance->check_out_status == 'ot')
                                        <span class="badge bg-primary">Đã OT</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @component('components.pagination.pagination', [
                    'currentPage' => $currentPage,
                    'totalPages' => $totalPages,
                ])
                @endcomponent

            </div>
        </div>
    </div>
@endsection
