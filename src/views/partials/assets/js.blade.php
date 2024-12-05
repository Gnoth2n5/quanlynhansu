<script src="/assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="/assets/vendors/chart.js/Chart.min.js"></script>
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="/assets/js/dataTables.select.min.js"></script>
{{-- custom.js --}}
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="/assets/js/off-canvas.js"></script>
<script src="/assets/js/hoverable-collapse.js"></script>
<script src="/assets/js/template.js"></script>
<script src="/assets/js/settings.js"></script>
<script src="/assets/js/todolist.js"></script>
{{-- <script src="/assets/js/select2.js"></script> --}}
<script src="/assets/vendors/select2/select2.min.js"></script>

{{-- <script src="/assets/js/select2-bootstrap.min.js"></script> --}}
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/assets/js/dashboard.js"></script>
<script src="/assets/js/Chart.roundedBarCharts.js"></script>
<!-- End custom js for this page-->
{{-- Nhúng JavaScript của Toastr --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.js"></script>
<script src="/assets/js/custom.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cấu hình thông báo
        toastr.options = {
            "closeButton": true, // Hiển thị nút đóng
            "debug": false, // Tắt chế độ debug
            "newestOnTop": true, // Đặt thông báo mới nhất lên trên
            "progressBar": true, // Hiển thị thanh tiến trình
            "positionClass": "toast-top-right", // Vị trí thông báo
            "preventDuplicates": true, // Ngăn chặn thông báo trùng lặp
            "onclick": null, // Hành động khi click vào thông báo
            "showDuration": "300", // Thời gian hiển thị hiệu ứng (ms)
            "hideDuration": "1000", // Thời gian ẩn hiệu ứng (ms)
            "timeOut": "3000", // Thời gian thông báo tự động ẩn (ms)
            "extendedTimeOut": "1000", // Thời gian chờ sau khi hover (ms)
            "showEasing": "swing", // Hiệu ứng khi hiển thị
            "hideEasing": "linear", // Hiệu ứng khi ẩn
            "showMethod": "fadeIn", // Phương thức hiển thị
            "hideMethod": "fadeOut" // Phương thức ẩn
        };
        // Lấy tham số từ URL
        const urlParams = new URLSearchParams(window.location.search);
        let message = urlParams.get('msg');
        const type = urlParams.get('status');
        history.replaceState(null, '', window.location.pathname);
        // Kiểm tra và hiển thị thông báo
        if (message && type && typeof toastr[type] === 'function') {
            // Thay thế dấu cộng bằng khoảng trắng và giải mã
            message = decodeURIComponent(message.replace(/\+/g, ' '));
            toastr[type](message); // toastr.success/toastr.error
        }
    });
</script>

<script>
    // Hàm cập nhật đồng hồ thời gian thực
    function updateClock() {
        const clockElement = document.getElementById('time-badge');
        const currentTime = new Date();
        const hours = String(currentTime.getHours()).padStart(2, '0');
        const minutes = String(currentTime.getMinutes()).padStart(2, '0');
        const seconds = String(currentTime.getSeconds()).padStart(2, '0');
        clockElement.textContent = `${hours}:${minutes}:${seconds}`;
    }

    // Cập nhật đồng hồ mỗi giây
    setInterval(updateClock, 1000);

    // Gọi hàm cập nhật đồng hồ ngay khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        updateClock();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // Định dạng giờ: phút (24 giờ)
            time_24hr: true // Hiển thị dạng 24 giờ
        });
    });
</script>

<script>
    const SweetAlert = (event, msg, status, {
        confirmBtn = true,
        cancelBtn = false,
        time = null,
        url = '',
        element = null
    } = {}) => {

        if (event) {
            event.preventDefault();
        }

        if (element && element.tagName === 'A' && element.href) {
            url = element.href;
        }

        const swalConfig = {
            icon: status,
            title: msg,
            showConfirmButton: confirmBtn,
            showCancelButton: cancelBtn,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            timer: time,
            timerProgressBar: true,
        };

        Swal.fire(swalConfig).then((result) => {
            if (result.isConfirmed && url) {
                window.location.href = url;
            }
        });
    }
</script>
