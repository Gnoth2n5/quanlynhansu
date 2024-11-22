<!-- views/stat-card.blade.php -->
<div class="col-md-3 mb-4 stretch-card transparent">
    <div class="card {{ $cardClass }}">
        <div class="card-body">
            <p class="mb-4">{{ $title }}</p>
            <p class="fs-30 mb-2">{{ $value }}</p>
            <p>{{ $percentage }} ({{ $period }})</p>
        </div>
    </div>
</div>
