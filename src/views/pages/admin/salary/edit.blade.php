@extends('layouts.defaultLayout')

@section('title', 'Sửa Bảng lương')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container mt-3">
                    <h2 class="text-center">Cập nhật Bảng lương</h2>
                    <form id="createOfficeForm" action="{{ $_ENV['APP_URL'] }}/admin/update-salary" method="POST"
                        class="mt-4">

                        <div class="mb-3 select">
                            <label for="nameUser" class="form-label">Tên Nhân viên</label>
                            <input type="text" class="form-control" value="{{ $salary->users->full_name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="base" class="form-label">Lương cơ bản</label>
                            <input type="number" step="0.01" max="99999999.99" min="1" class="form-control"
                                id="base" name="base" value="{{ $salary->base_salary }}"
                                placeholder="Nhập lương cơ bản">
                        </div>

                        <!-- Khấu trừ -->
                        <div class="mb-3">
                            <label class="form-label">Khấu trừ</label>
                            <div id="deductions-container">
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" max="99999999.99" min="0"
                                        class="form-control" name="deductions[amount][]" placeholder="Số tiền">
                                    <input type="text" class="form-control" name="deductions[description][]"
                                        placeholder="Mô tả">
                                    <button type="button" class="btn btn-primary btn-rounded btn-icon add-deduction">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>

                                @foreach ($adjusment as $item)
                                    @if ($item->type == 'deduction')
                                        <div class="input-group mb-2">
                                            <input type="hidden" name="deduction[id][]" value="{{$item->id}}">
                                            <input type="number" step="0.01" max="99999999.99" min="0"
                                                class="form-control" name="bonus[amount][]" placeholder="Số tiền"
                                                value="{{ $item->amount }}">
                                            <input type="text" class="form-control" name="bonus[description][]"
                                                placeholder="Mô tả" value="{{ $item->description }}">
                                            <button type="button"
                                                class="btn btn-danger btn-rounded btn-icon remove-deduction">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Thưởng -->
                        <div class="mb-3">
                            <label class="form-label">Thưởng thêm</label>
                            <div id="bonus-container">
                                <div class="input-group mb-2">
                                    <input type="number" step="0.01" max="99999999.99" min="0"
                                        class="form-control" name="bonus[amount][]" placeholder="Số tiền">
                                    <input type="text" class="form-control" name="bonus[description][]"
                                        placeholder="Mô tả">
                                    <button type="button" class="btn btn-primary btn-rounded btn-icon add-bonus">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>

                                @foreach ($adjusment as $item)
                                    @if ($item->type == 'bonus')
                                        <div class="input-group mb-2">
                                            <input type="hidden" name="bonus[id][]" value="{{$item->id}}">
                                            <input type="number" step="0.01" max="99999999.99" min="0"
                                                class="form-control" name="bonus[amount][]" placeholder="Số tiền"
                                                value="{{ $item->amount }}">
                                            <input type="text" class="form-control" name="bonus[description][]"
                                                placeholder="Mô tả" value="{{ $item->description }}">
                                            <button type="button" class="btn btn-danger btn-rounded btn-icon remove-bonus">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                        @foreach ($adjusment as $item)
                            @if ($item->type == 'ot')
                                <div class="mb-3">
                                    <label for="total" class="form-label">{{ $item->description }}</label>
                                    <input type="number" step="0.01" max="99999999.99" min="0"
                                        class="form-control" id="total" name="total" value="{{ $item->amount }}"
                                        readonly>
                                </div>
                            @endif
                        @endforeach

                        <button type="submit" class="btn btn-primary">Cập nhật bảng lương</button>
                        <a href="{{ $_ENV['APP_URL'] }}/admin/salary-management" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Thêm khấu trừ
            document.querySelector('.add-deduction').addEventListener('click', function() {
                const container = document.getElementById('deductions-container');
                const newInput = document.createElement('div');
                newInput.className = 'input-group mb-2';
                newInput.innerHTML = `
            <input type="number" step="0.01" max="99999999.99" min="0" class="form-control" name="deductions[amount][]" placeholder="Số tiền">
            <input type="text" class="form-control" name="deductions[description][]" placeholder="Mô tả">
            <button type="button" class="btn btn-secondary btn-rounded btn-icon remove-deduction">
                <i class="fa-solid fa-minus"></i>
            </button>
        `;
                container.appendChild(newInput);
            });

            // Remove khấu trừ
            document.getElementById('deductions-container').addEventListener('click', function(e) {
                if (e.target.closest('.remove-deduction')) {
                    Swal.fire({
                        text: "Bạn có chắc chắn muốn xóa mục khấu trừ này không?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const deductionItem = e.target.closest('.input-group');
                            deductionItem.remove();
                        }
                    });
                }
            });

            // Thêm thưởng
            document.querySelector('.add-bonus').addEventListener('click', function() {
                const container = document.getElementById('bonus-container');
                const newInput = document.createElement('div');
                newInput.className = 'input-group mb-2';
                newInput.innerHTML = `
            <input type="number" step="0.01" max="99999999.99" min="0" class="form-control" name="bonus[amount][]" placeholder="Số tiền">
            <input type="text" class="form-control" name="bonus[description][]" placeholder="Mô tả">
            <button type="button" class="btn btn-secondary btn-rounded btn-icon remove-bonus">
                <i class="fa-solid fa-minus"></i>
            </button>
        `;
                container.appendChild(newInput);
            });

            // Remove thưởng
            document.getElementById('bonus-container').addEventListener('click', function(e) {
                if (e.target.closest('.remove-bonus')) {
                    Swal.fire({
                        text: "Bạn có chắc chắn muốn xóa mục bonus này không?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const bonusItem = e.target.closest('.input-group');
                            bonusItem.remove();
                        }
                    });
                }
            });
        });
    </script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector('#createOfficeForm');
            const baseSalary = document.querySelector("input[name='base']");
            const deductions = document.querySelector("input[name='deductions']");
            const bonus = document.querySelector("input[name='bonus']");

            // Hàm validate số
            function validateNumberField(inputElement, minValue, maxValue, errorMessage) {
                const value = parseFloat(inputElement.value.trim());
                const parent = inputElement.parentElement;

                // Xóa thông báo lỗi trước khi kiểm tra
                parent.querySelectorAll(".error-message").forEach(el => el.remove());

                if (isNaN(value) || value < minValue || value > maxValue) {
                    const errorEl = document.createElement('div');
                    errorEl.classList.add('error-message', 'text-danger', 'mt-1');
                    errorEl.textContent = errorMessage;
                    parent.appendChild(errorEl);
                    return false;
                }
                return true;
            }

            // Kiểm tra khi mất focus (blur)
            baseSalary.addEventListener('blur', function () {
                validateNumberField(baseSalary, 1, 99999999.99, "Lương cơ bản phải lớn hơn 0 và nhỏ hơn 99,999,999.99.");
            });

            deductions.addEventListener('blur', function () {
                validateNumberField(deductions, 0, 99999999.99, "Khấu trừ phải từ 0 đến 99,999,999.99.");
            });

            bonus.addEventListener('blur', function () {
                validateNumberField(bonus, 0, 99999999.99, "Thưởng phải từ 0 đến 99,999,999.99.");
            });

            // Xử lý gửi form
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Ngăn việc gửi form nếu không hợp lệ

                let isValid = true;

                // Kiểm tra các trường dữ liệu
                if (!validateNumberField(baseSalary, 1, 99999999.99, "Lương cơ bản phải lớn hơn 0 và nhỏ hơn 99,999,999.99.")) {
                    isValid = false;
                }

                if (!validateNumberField(deductions, 0, 99999999.99, "Khấu trừ phải từ 0 đến 99,999,999.99.")) {
                    isValid = false;
                }

                if (!validateNumberField(bonus, 0, 99999999.99, "Thưởng phải từ 0 đến 99,999,999.99.")) {
                    isValid = false;
                }

                // Nếu hợp lệ, gửi form
                if (isValid) {
                    form.submit();
                }
            });
        });
    </script> --}}
@endsection
