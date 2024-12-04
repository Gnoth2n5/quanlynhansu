@extends('layouts.defaultLayout')

@section('title', 'Chỉnh sửa ca làm việc')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-5">
                    <h2 class="text-center">Phân ca</h2>

                    <form action="{{ $_ENV['APP_URL'] }}/admin/assign-shift" method="POST" class="mt-4">

                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <div class="mb-4">
                            <label for="fullname" class="form-label fw-bold">Họ tên</label>
                            <input type="text" class="form-control form-control-lg" id="fullname" name="fullname"
                                value="{{ $user->full_name }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="uid" class="form-label fw-bold">UID</label>
                            <input type="text" class="form-control form-control-lg" id="uid" name="uid"
                                value="{{ $user->UID }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="shift">Ca làm việc</label>
                            <select class="form-select form-select-lg w-100 p-2" id="shift" name="shift">
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}"
                                        {{ $user->shift && $user->shift[0]->id == $shift->id ? 'selected' : '' }}>
                                        {{ $shift->shift_name }} [{{ $shift->start_time }} - {{ $shift->end_time }}]
                                        ({{ $shift->is_overtime == 0 ? 'Không OT' : 'OT' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <input type="reset" class="btn btn-secondary" value="Khôi phục lại">
                        <a href="{{ $_ENV['APP_URL'] }}/admin/user-shift" class="btn btn-info">Quay lại</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
