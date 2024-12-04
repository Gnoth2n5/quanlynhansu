<div class="card">
    <div class="card-body row">
        <div class="col-lg-6">
            <p class="card-title">Chấm công trong tháng</p>
            <div class="d-flex flex-wrap mb-2">
                <div class="mr-5 mt-3">
                    <p class="text-muted">Tổng số chấm công</p>
                    <h3 class="text-primary fs-30 font-weight-medium">{{ $totalCheckIn ?? 0 }}</h3>
                </div>
                <div class="mr-5 mt-3">
                    <p class="text-muted">Chấm công muộn</p>
                    <h3 class="text-primary fs-30 font-weight-medium">{{ $checkInLate ?? 0 }}</h3>
                </div>
                <div class="mr-5 mt-3">
                    <p class="text-muted">Chấm công đúng giờ</p>
                    <h3 class="text-primary fs-30 font-weight-medium">{{ $checkInOnTime ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <canvas id="attendance-chart"></canvas>
        </div>
    </div>
</div>
