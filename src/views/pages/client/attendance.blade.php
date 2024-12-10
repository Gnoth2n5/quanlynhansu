@extends('layouts.defaultLayout')

@section('title', 'Bảng chấm công')

@section('content')
    <div class="grid-margin stretch-card col-lg-12 mb-3">
        <div class="card shadow-sm" style="padding-left: 2rem;">
            <div class="card-body">
                <h5 class="card-title">Lọc</h5>
                <form method="GET" action="{{ $_ENV['APP_URL'] }}/user/attendance">
                    <div class="row g-3">
                        <!-- From Date -->
                        <div class="col-md-3">
                            <label for="from-date" class="form-label">Từ:</label>
                            <div class="input-group">
                                <input type="date" id="from-date" name="from" class="form-control"
                                    placeholder="Select date" value="{{ get('from', '') }}">
                            </div>
                        </div>

                        <!-- To Date -->
                        <div class="col-md-3">
                            <label for="to-date" class="form-label">Đến:</label>
                            <div class="input-group">
                                <input type="date" id="to-date" name="to" class="form-control"
                                    placeholder="Select date" value="{{ get('to', '') }}">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-2">
                            <label for="status" class="form-label">Trạng thái CheckIn</label>
                            <select id="status" class="form-select form-control" name="check_in_status">
                                <option value="all" {{ get('check_in_status') == 'all' ? 'selected' : '' }}>Tất cả
                                </option>
                                <option value="on_time" {{ get('check_in_status') == 'on_time' ? 'selected' : '' }}>Đúng
                                    giờ</option>
                                <option value="late" {{ get('check_in_status') == 'late' ? 'selected' : '' }}>Muộn
                                </option>
                                <option value="absent" {{ get('check_in_status') == 'absent' ? 'selected' : '' }}>Vắng
                                </option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-2">
                            <label for="status" class="form-label">Trạng thái CheckOut</label>
                            <select id="status" class="form-select form-control" name="check_out_status">
                                <option value="all" {{ get('check_out_status') == 'all' ? 'selected' : '' }}>Tất cả</option>
                                <option value="on_time" {{ get('check_out_status') == 'on_time' ? 'selected' : '' }}>Đúng giờ</option>
                                <option value="early_exit" {{ get('check_out_status') == 'early_exit' ? 'selected' : '' }}>Ra sớm</option>
                                <option value="ot" {{ get('check_out_status') == 'ot' ? 'selected' : '' }}>Tăng ca</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="{{ $_ENV['APP_URL'] }}/user/attendance" class="btn btn-danger">Xóa bộ lọc</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

                        @if (count($data) === 0)
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif

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
