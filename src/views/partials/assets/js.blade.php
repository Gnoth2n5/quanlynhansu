<script src="/assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="/assets/vendors/chart.js/Chart.min.js"></script>
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="/assets/js/dataTables.select.min.js"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="/assets/js/off-canvas.js"></script>
<script src="/assets/js/hoverable-collapse.js"></script>
<script src="/assets/js/template.js"></script>
<script src="/assets/js/settings.js"></script>
<script src="/assets/js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/assets/js/dashboard.js"></script>
<script src="/assets/js/Chart.roundedBarCharts.js"></script>
<!-- End custom js for this page-->
{{-- Nhúng JavaScript của Toastr --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.js"></script>
 

<script>
    document.addEventListener('DOMContentLoaded', function() {
     // Lấy tham số từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('msg');
        const type = urlParams.get('status');
        // Kiểm tra và hiển thị thông báo
        if (message && type && typeof toastr[type] === 'function') {
            toastr[type](decodeURIComponent(message)); // toastr.success/toastr.error
        }
        // Reset URL
        history.replaceState(null, '', window.location.pathname);
    });
</script>


<script>
    const SweetAlert = (msg, status, {
        confirmBtn = true,
        cancelBtn = false,
        time = null,
        url = ''
    } = {}) => {

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
